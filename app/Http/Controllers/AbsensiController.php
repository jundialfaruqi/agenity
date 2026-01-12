<?php

namespace App\Http\Controllers;

use App\Models\AgendaSession;
use App\Models\Absensi;
use App\Models\OpdMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function show($token)
    {
        $session = AgendaSession::where('token', $token)
            ->where('is_active', true)
            ->with('agenda')
            ->firstOrFail();

        $agenda = $session->agenda;

        // 1. Check Visibility (Private requirement)
        if ($agenda->visibility === 'private' && !Auth::check()) {
            return view('absensi.error', [
                'message' => 'Agenda ini bersifat privat. Anda harus login ke akun Agenity Anda untuk dapat mengisi absensi.',
                'session' => $session,
                'show_login' => true
            ]);
        }

        // 2. Check if session is within time range
        $now = now();
        if ($now->lt($session->start_at) || $now->gt($session->end_at)) {
            return view('absensi.error', [
                'message' => 'Sesi absensi ini belum dimulai atau sudah berakhir.',
                'session' => $session
            ]);
        }

        $opds = OpdMaster::orderBy('name')->get();
        return view('absensi.show', compact('session', 'opds'));
    }

    public function store(Request $request, $token)
    {
        $session = AgendaSession::where('token', $token)
            ->where('is_active', true)
            ->with('agenda')
            ->firstOrFail();

        $agenda = $session->agenda;

        // Security check for private visibility
        if ($agenda->visibility === 'private' && !Auth::check()) {
            return back()->with('error', 'Anda harus login untuk mengisi absensi ini.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip_nik' => 'nullable|string|max:255',
            'handphone' => 'required|string|max:20',
            'asal_daerah' => 'required|in:dalam_kota,luar_kota',
            'master_opd_id' => 'nullable|exists:opd_masters,id',
            'asal_instansi' => 'nullable|string|max:255',
            'jabatan_pekerjaan' => 'required|string|max:255',
            'ttd' => 'required|string', // Base64 signature
        ]);

        try {
            DB::beginTransaction();

            $absensi = new Absensi();
            $absensi->agenda_session_id = $session->id;
            $absensi->name = $validated['name'];
            $absensi->nip_nik = $validated['nip_nik'];
            $absensi->handphone = $validated['handphone'];
            $absensi->asal_daerah = $validated['asal_daerah'];
            $absensi->master_opd_id = $validated['master_opd_id'];
            $absensi->asal_instansi = $validated['asal_instansi'];
            $absensi->jabatan_pekerjaan = $validated['jabatan_pekerjaan'];
            $absensi->ttd_path = $validated['ttd']; // Storing base64 for simplicity in this MVP
            $absensi->checkin_time = now();
            $absensi->ip_address = $request->ip();
            $absensi->user_agent = $request->userAgent();
            $absensi->save();

            DB::commit();

            return redirect()->route('absensi.success', [
                'token' => $token,
                'absensi' => $absensi->id
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }

    public function success($token, Absensi $absensi)
    {
        $session = AgendaSession::where('token', $token)
            ->where('is_active', true)
            ->with('agenda')
            ->firstOrFail();

        // Ensure the absensi belongs to this session
        if ($absensi->agenda_session_id !== $session->id) {
            abort(404);
        }

        return view('absensi.success', [
            'session' => $session,
            'absensi' => $absensi
        ]);
    }
}
