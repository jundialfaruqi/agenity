<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Event;
use App\Models\Survey;
use App\Models\SurveyToken;
use App\Services\AgendaService;
use App\Services\SurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index(Request $request, AgendaService $service, SurveyService $surveyService)
    {
        $stats = $service->getStats();

        // Security: Validate and sanitize filter input
        $allowedFilters = ['all', 'today', 'tomorrow', '7_days'];
        $currentFilter = $request->get('filter', 'all');
        if (!in_array($currentFilter, $allowedFilters)) {
            $currentFilter = 'all';
        }

        $agendasQuery = Agenda::query()
            ->with(['opdMaster', 'sessions'])
            ->where('status', 'active')
            ->where('visibility', 'public');

        // Apply filters using Laravel Query Builder (Prepared Statements)
        $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
        $tomorrow = \Carbon\Carbon::now('Asia/Jakarta')->addDay()->toDateString();
        $next7Days = \Carbon\Carbon::now('Asia/Jakarta')->addDays(6)->toDateString();

        if ($currentFilter === 'today') {
            $agendasQuery->whereDate('date', $today);
        } elseif ($currentFilter === 'tomorrow') {
            $agendasQuery->whereDate('date', $tomorrow);
        } elseif ($currentFilter === '7_days') {
            $agendasQuery->whereBetween('date', [$today, $next7Days]);
        }
        // If filter is 'all', no date filter is applied

        $agendas = $agendasQuery
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(6, ['*'], 'agenda_page')
            ->withQueryString();

        // Map agendas to add view-specific attributes
        $agendas->getCollection()->transform(function ($agenda) {
            // Status Badge Class
            $agenda->status_badge_class = match ($agenda->status) {
                'active' => 'badge-success',
                'draft' => 'badge-warning',
                'finished' => 'badge-neutral',
                default => 'badge-ghost',
            };

            // Time Status Logic
            $now = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();
            $agendaDate = \Carbon\Carbon::parse($agenda->date, 'Asia/Jakarta')->startOfDay();
            $diff = $now->diffInDays($agendaDate, false);

            $timeStatus = [
                'label' => '',
                'class' => 'badge-ghost',
                'text_class' => 'text-base-content/50'
            ];

            if ($diff == 0) {
                $timeStatus = [
                    'label' => 'Hari Ini',
                    'class' => 'badge-success text-success-content',
                    'text_class' => 'text-success font-bold'
                ];
            } elseif ($diff == 1) {
                $timeStatus = [
                    'label' => 'Besok',
                    'class' => 'badge-info text-info-content',
                    'text_class' => 'text-info font-medium'
                ];
            } elseif ($diff > 1) {
                $timeStatus = [
                    'label' => $diff . ' Hari Lagi',
                    'class' => 'badge-primary text-primary-content',
                    'text_class' => 'text-primary'
                ];
            } elseif ($diff == -1) {
                $timeStatus = [
                    'label' => 'Kemarin',
                    'class' => 'badge-error text-error-content',
                    'text_class' => 'text-error'
                ];
            } else {
                $timeStatus = [
                    'label' => abs($diff) . ' Hari Lalu',
                    'class' => 'badge-ghost',
                    'text_class' => 'text-base-content/40'
                ];
            }
            $agenda->time_status = $timeStatus;

            return $agenda;
        });

        // Fetch Public Surveys
        $surveys = Survey::where('visibility', 'public')
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->with(['opd'])
            ->withCount('respondents')
            ->latest()
            ->paginate(6, ['*'], 'survey_page')
            ->withQueryString();

        // Fetch Public Events
        $events = Event::where('status', 'active')
            ->with(['opdMaster'])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(6, ['*'], 'event_page')
            ->withQueryString();

        // Map events to add view-specific attributes
        $events->getCollection()->transform(function ($event) {
            $now = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();
            $eventDate = \Carbon\Carbon::parse($event->date, 'Asia/Jakarta')->startOfDay();
            $diff = $now->diffInDays($eventDate, false);

            $timeStatus = [
                'label' => '',
                'class' => 'badge-ghost',
                'text_class' => 'text-base-content/50'
            ];

            if ($diff == 0) {
                $timeStatus = [
                    'label' => 'Hari Ini',
                    'class' => 'badge-success text-success-content',
                    'text_class' => 'text-success font-bold'
                ];
            } elseif ($diff == 1) {
                $timeStatus = [
                    'label' => 'Besok',
                    'class' => 'badge-info text-info-content',
                    'text_class' => 'text-info font-medium'
                ];
            } elseif ($diff > 1) {
                $timeStatus = [
                    'label' => $diff . ' Hari Lagi',
                    'class' => 'badge-primary text-primary-content',
                    'text_class' => 'text-primary'
                ];
            } elseif ($diff == -1) {
                $timeStatus = [
                    'label' => 'Kemarin',
                    'class' => 'badge-error text-error-content',
                    'text_class' => 'text-error'
                ];
            } else {
                $timeStatus = [
                    'label' => abs($diff) . ' Hari Lalu',
                    'class' => 'badge-ghost',
                    'text_class' => 'text-base-content/40'
                ];
            }
            $event->time_status = $timeStatus;
            return $event;
        });

        return view('welcome', compact('stats', 'agendas', 'currentFilter', 'surveys', 'events'));
    }

    public function showAgenda(Agenda $agenda)
    {
        if ($agenda->status !== 'active' || $agenda->visibility !== 'public') {
            abort(404);
        }

        $agenda->load(['opdMaster', 'sessions', 'user']);
        return view('agenda.public-detail', compact('agenda'));
    }

    public function showEvent(Event $event)
    {
        if ($event->status !== 'active') {
            abort(404);
        }

        $event->load(['opdMaster', 'user']);

        // Get 5 upcoming events for sidebar
        $upcomingEvents = Event::where('status', 'active')
            ->where('id', '!=', $event->id)
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        return view('event.public-detail', compact('event', 'upcomingEvents'));
    }

    public function surveyDetail(Survey $survey, Request $request)
    {
        $survey->load(['questions.options', 'opd']);

        if ($survey->visibility === 'private') {
            return redirect()->route('welcome')->with('error', 'Survei ini bersifat privat.');
        }

        return $this->renderSurvey($survey, $request);
    }

    public function surveyByToken($token, Request $request)
    {
        $surveyToken = SurveyToken::where('token', $token)->firstOrFail();
        $survey = Survey::with(['questions.options', 'opd'])->findOrFail($surveyToken->survey_id);

        return $this->renderSurvey($survey, $request);
    }

    protected function renderSurvey(Survey $survey, Request $request)
    {
        // Check if survey is active and within date range
        $today = now();
        if (!$survey->is_active || $survey->start_date > $today || $survey->end_date < $today) {
            return redirect()->route('welcome')->with('error', 'Survei ini tidak sedang aktif.');
        }

        // Anti-duplication check: IP Address (Already filled check)
        $existingRespondent = $survey->respondents()
            ->where('ip_address', $request->ip())
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if ($existingRespondent) {
            return view('survey.public_already_filled', compact('survey'));
        }

        // Check respondent quota
        if ($survey->max_respondents && $survey->respondents()->count() >= $survey->max_respondents) {
            return view('survey.public_quota_full', compact('survey'));
        }

        return view('survey.public_fill', compact('survey'));
    }

    public function surveySubmit(Request $request, Survey $survey)
    {
        $survey->load('questions');

        // Check respondent quota before processing
        if ($survey->max_respondents && $survey->respondents()->count() >= $survey->max_respondents) {
            return view('survey.public_quota_full', compact('survey'));
        }

        // Anti-duplication check: IP Address
        $existingRespondent = $survey->respondents()
            ->where('ip_address', $request->ip())
            ->where('created_at', '>=', now()->subDay()) // Limit to once per 24 hours per IP
            ->first();

        if ($existingRespondent) {
            return view('survey.public_already_filled', compact('survey'));
        }

        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'nik' => 'nullable|string|max:16',
            'occupation' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
        ];

        foreach ($survey->questions as $question) {
            if ($question->is_required) {
                $rules['answers.' . $question->id] = 'required';
            }
        }

        $validated = $request->validate($rules);

        try {
            DB::transaction(function () use ($request, $survey, $validated) {
                $respondent = $survey->respondents()->create([
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'nik' => $validated['nik'] ?? null,
                    'occupation' => $validated['occupation'] ?? null,
                    'age' => $validated['age'] ?? null,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'submitted_at' => now(),
                ]);

                if ($request->has('answers')) {
                    foreach ($request->answers as $questionId => $answer) {
                        $question = $survey->questions()->find($questionId);
                        if (!$question) continue;

                        $answerData = [
                            'question_id' => $questionId,
                        ];

                        if (in_array($question->type, ['single_choice', 'rating'])) {
                            if ($question->type === 'single_choice') {
                                $answerData['option_id'] = $answer;
                            } else {
                                $answerData['answer_text'] = $answer;
                            }
                        } elseif ($question->type === 'multiple_choice') {
                            if (is_array($answer)) {
                                foreach ($answer as $optionId) {
                                    $respondent->answers()->create([
                                        'question_id' => $questionId,
                                        'option_id' => $optionId,
                                    ]);
                                }
                                continue;
                            }
                        } else {
                            $answerData['answer_text'] = $answer;
                        }

                        $respondent->answers()->create($answerData);
                    }
                }
            });

            return view('survey.public_success', compact('survey'));
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
