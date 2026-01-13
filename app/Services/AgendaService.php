<?php

namespace App\Services;

use App\Models\Agenda;
use App\Models\AgendaSession;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AgendaService
{
    public function listAgendas(?string $search = null, ?string $status = null, int $perPage = 10)
    {
        $query = Agenda::query()->with(['opdMaster', 'user', 'sessions']);

        // Filter by user if role is admin-opd
        if (Auth::check() && Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('master_opd_id', $user->opd_master_id);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('jenis_agenda', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhereHas('opdMaster', function ($oq) use ($search) {
                        $oq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('singkatan', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($status) {
            if ($status === 'past_active') {
                $query->where('status', 'active')
                    ->where('date', '<', \Carbon\Carbon::now()->toDateString());
            } else {
                $query->where('status', $status);
            }
        }

        return $query->orderBy('date', 'desc')->orderBy('start_time', 'desc')->paginate($perPage);
    }

    public function getStats(): array
    {
        $query = Agenda::query();

        // Filter by user if role is admin-opd
        if (Auth::check() && Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('master_opd_id', $user->opd_master_id);
            });
        }

        $stats = [
            'total' => (clone $query)->count(),
            'active' => (clone $query)->where('status', 'active')->count(),
            'draft' => (clone $query)->where('status', 'draft')->count(),
            'finished' => (clone $query)->where('status', 'finished')->count(),
            'past_active' => (clone $query)->where('status', 'active')
                ->where('date', '<', \Carbon\Carbon::now()->toDateString())
                ->count(),
        ];

        return $stats;
    }

    public function createAgenda(array $data): Agenda
    {
        $agenda = Agenda::create($data);

        // Automatically create the first session
        $this->createSession($agenda, [
            'session_name' => 'Sesi Utama',
            'session_type' => $agenda->mode === 'online' ? 'online' : 'offline',
            'start_at' => $agenda->date . ' ' . $agenda->start_time,
            'end_at' => $agenda->date . ' ' . $agenda->end_time,
            'is_active' => $agenda->status === 'active',
        ]);

        return $agenda;
    }

    public function updateAgenda(Agenda $agenda, array $data): Agenda
    {
        $oldDate = $agenda->date;
        $oldStart = $agenda->start_time;
        $oldEnd = $agenda->end_time;
        $oldStatus = $agenda->status;

        $agenda->update($data);

        // Sync the main session if time or status changed
        $mainSession = $agenda->sessions()->where('session_name', 'Sesi Utama')->first();
        if ($mainSession) {
            if (
                $oldDate !== $agenda->date ||
                $oldStart !== $agenda->start_time ||
                $oldEnd !== $agenda->end_time ||
                $oldStatus !== $agenda->status
            ) {
                $mainSession->update([
                    'start_at' => $agenda->date . ' ' . $agenda->start_time,
                    'end_at' => $agenda->date . ' ' . $agenda->end_time,
                    'is_active' => $agenda->status === 'active',
                ]);
            }
        }

        return $agenda;
    }

    public function createSession(Agenda $agenda, array $data): AgendaSession
    {
        $token = Str::random(32);
        $qrCodePath = 'qrcodes/' . $token . '.png';

        // Generate QR Code
        $url = route('absensi.show', ['token' => $token]);
        $qrCode = QrCode::format('png')->size(500)->generate($url);
        Storage::disk('public')->put($qrCodePath, $qrCode);

        $data['token'] = $token;
        $data['qr_code_path'] = $qrCodePath;

        return $agenda->sessions()->create($data);
    }

    public function suggest(string $q): Collection
    {
        $query = Agenda::query()->with(['opdMaster']);

        // Filter by user if role is admin-opd
        if (Auth::check() && Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('master_opd_id', $user->opd_master_id);
            });
        }

        return $query->where(function ($query) use ($q) {
            $query->where('title', 'like', '%' . $q . '%')
                ->orWhere('jenis_agenda', 'like', '%' . $q . '%')
                ->orWhere('location', 'like', '%' . $q . '%')
                ->orWhereHas('opdMaster', function ($oq) use ($q) {
                    $oq->where('name', 'like', '%' . $q . '%')
                        ->orWhere('singkatan', 'like', '%' . $q . '%');
                });
        })
            ->limit(5)
            ->get()
            ->map(function ($a) {
                return [
                    'title' => $a->title,
                    'jenis' => $a->jenis_agenda,
                    'opd' => $a->opdMaster->singkatan ?? $a->opdMaster->name ?? '',
                    'status' => $a->status,
                ];
            });
    }
}
