<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\OpdMaster;
use App\Services\SurveyService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(Request $request, SurveyService $service)
    {
        $q = (string) $request->query('q', '');
        $visibility = (string) $request->query('visibility', '');
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $surveys = $service->listSurveys($q ?: null, $visibility ?: null, $perPage);

        // Map surveys to add view-specific attributes
        $surveys->getCollection()->transform(function ($survey) {
            $survey->status_badge_class = $survey->is_active ? 'badge-success' : 'badge-ghost';
            $survey->visibility_status = [
                'label' => ucfirst($survey->visibility),
                'class' => match ($survey->visibility) {
                    'public' => 'badge-primary',
                    'private' => 'badge-error',
                    default => 'badge-ghost',
                }
            ];
            return $survey;
        });

        $stats = $service->getStats();

        return view('survey.index', compact('surveys', 'q', 'visibility', 'stats'));
    }

    public function suggest(Request $request, SurveyService $service)
    {
        $q = (string) $request->query('q', '');
        if ($q === '') {
            return response()->json(['data' => []]);
        }
        return response()->json(['data' => $service->suggestSurveys($q)]);
    }

    public function create()
    {
        $opds = OpdMaster::orderBy('name')->get();
        return view('survey.create', compact('opds'));
    }

    public function store(Request $request, SurveyService $service): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'opd_id' => 'required|exists:opd_masters,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_respondents' => 'nullable|integer|min:1',
            'visibility' => 'required|in:public,private',
        ]);

        // Security: admin-opd can only create survey for their own OPD
        if ($user->hasRole('admin-opd')) {
            $validated['opd_id'] = $user->opd_master_id;
        }

        $validated['created_by'] = $user->id;
        $validated['is_active'] = $request->has('is_active');

        try {
            $service->createSurvey($validated);
            return redirect()->route('survey.index')->with('success', 'Survei berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan survei: ' . $e->getMessage());
        }
    }

    public function edit(Survey $survey)
    {
        // Authorization for admin-opd
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin-opd')) {
            if ($survey->created_by !== $user->id && $survey->opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke survei ini.');
            }
        }

        $opds = OpdMaster::orderBy('name')->get();
        return view('survey.edit', compact('survey', 'opds'));
    }

    public function update(Request $request, SurveyService $service, Survey $survey): RedirectResponse
    {
        // Authorization for admin-opd
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin-opd')) {
            if ($survey->created_by !== $user->id && $survey->opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke survei ini.');
            }
        }

        $validated = $request->validate([
            'opd_id' => 'required|exists:opd_masters,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_respondents' => 'nullable|integer|min:1',
            'visibility' => 'required|in:public,private',
        ]);

        // Checkbox handling
        $validated['is_active'] = $request->has('is_active');

        try {
            $service->updateSurvey($survey, $validated);
            return redirect()->route('survey.index')->with('success', 'Survei berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Survey $survey): RedirectResponse
    {
        // Authorization for admin-opd
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin-opd')) {
            if ($survey->created_by !== $user->id && $survey->opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke survei ini.');
            }
        }

        try {
            $survey->delete();
            return redirect()->route('survey.index')->with('success', 'Survei berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function storeQuestion(Request $request, SurveyService $service, Survey $survey): RedirectResponse
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:text,single_choice,multiple_choice,rating',
            'is_required' => 'nullable',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
        ]);

        try {
            $service->addQuestion($survey, $validated);
            return back()->with('success', 'Pertanyaan berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroyQuestion(SurveyService $service, \App\Models\SurveyQuestion $question): RedirectResponse
    {
        // Authorization check
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin-opd')) {
            if ($question->survey->created_by !== $user->id && $question->survey->opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke pertanyaan ini.');
            }
        }

        try {
            $service->deleteQuestion($question);
            return back()->with('success', 'Pertanyaan berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function results(Survey $survey, SurveyService $service)
    {
        // Authorization for admin-opd
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin-opd')) {
            if ($survey->created_by !== $user->id && $survey->opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke hasil survei ini.');
            }
        }

        $results = $service->getSurveyResults($survey);
        return view('survey.results', compact('survey', 'results'));
    }

    public function exportPdf(Survey $survey, SurveyService $service)
    {
        // Authorization for admin-opd
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin-opd')) {
            if ($survey->created_by !== $user->id && $survey->opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke hasil survei ini.');
            }
        }

        $results = $service->getSurveyResults($survey);
        $pdf = Pdf::loadView('survey.pdf_results', compact('survey', 'results'));

        return $pdf->download('Hasil_Survei_' . str_replace(' ', '_', $survey->title) . '.pdf');
    }
}
