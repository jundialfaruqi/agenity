<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\OpdMaster;
use App\Services\AgendaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index(Request $request, AgendaService $service)
    {
        $q = (string) $request->query('q', '');
        $status = (string) $request->query('status', '');
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $agendas = $service->listAgendas($q ?: null, $status ?: null, $perPage);
        $stats = $service->getStats();

        return view('agenda.index', compact('agendas', 'q', 'status', 'stats'));
    }

    public function create()
    {
        $opds = OpdMaster::orderBy('name')->get();
        return view('agenda.create', compact('opds'));
    }

    public function store(Request $request, AgendaService $service): RedirectResponse
    {
        $validated = $request->validate([
            'master_opd_id' => 'required|exists:opd_masters,id',
            'title' => 'required|string|max:255',
            'jenis_agenda' => 'required|string|max:255',
            'visibility' => 'required|in:public,private',
            'mode' => 'required|in:online,offline,hybrid',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string|max:255',
            'link_paparan' => 'nullable|url',
            'link_zoom' => 'nullable|url',
            'link_streaming_youtube' => 'nullable|url',
            'link_lainnya' => 'nullable|url',
            'ket_link_lainnya' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'status' => 'required|in:draft,active,finished',
        ]);

        $validated['user_id'] = Auth::id();

        try {
            $service->createAgenda($validated);
            return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Agenda $agenda)
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($agenda->user_id !== $user->id && $agenda->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke agenda ini.');
            }
        }

        $opds = OpdMaster::orderBy('name')->get();
        return view('agenda.edit', compact('agenda', 'opds'));
    }

    public function update(Request $request, AgendaService $service, Agenda $agenda): RedirectResponse
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($agenda->user_id !== $user->id && $agenda->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke agenda ini.');
            }
        }

        $validated = $request->validate([
            'master_opd_id' => 'required|exists:opd_masters,id',
            'title' => 'required|string|max:255',
            'jenis_agenda' => 'required|string|max:255',
            'visibility' => 'required|in:public,private',
            'mode' => 'required|in:online,offline,hybrid',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string|max:255',
            'link_paparan' => 'nullable|url',
            'link_zoom' => 'nullable|url',
            'link_streaming_youtube' => 'nullable|url',
            'link_lainnya' => 'nullable|url',
            'ket_link_lainnya' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'status' => 'required|in:draft,active,finished',
        ]);

        $validated['user_id'] = Auth::id();

        try {
            $service->updateAgenda($agenda, $validated);
            return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($agenda->user_id !== $user->id && $agenda->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke agenda ini.');
            }
        }

        try {
            $agenda->delete();
            return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->route('agenda.index')->with('error', 'Gagal menghapus agenda: ' . $e->getMessage());
        }
    }

    public function export(Agenda $agenda)
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($agenda->user_id !== $user->id && $agenda->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke agenda ini.');
            }
        }

        $agenda->load(['sessions.absensis.opdMaster', 'opdMaster', 'user']);

        $pdf = Pdf::loadView('agenda.report-pdf', compact('agenda'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Absensi_' . str_replace(' ', '_', $agenda->title) . '.pdf');
    }

    public function showAbsensi(Agenda $agenda)
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($agenda->user_id !== $user->id && $agenda->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke agenda ini.');
            }
        }

        $agenda->load(['sessions.absensis.opdMaster', 'opdMaster']);
        return view('agenda.absensi', compact('agenda'));
    }

    public function suggest(Request $request, AgendaService $service)
    {
        $q = (string) $request->query('q', '');
        if ($q === '') {
            return response()->json(['data' => []]);
        }
        $suggestions = $service->suggest($q);
        return response()->json(['data' => $suggestions]);
    }
}
