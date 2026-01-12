<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Services\AgendaService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(AgendaService $service)
    {
        $stats = $service->getStats();

        $agendas = Agenda::query()
            ->with(['opdMaster', 'sessions'])
            ->where('status', 'active')
            ->where('visibility', 'public')
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

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

        return view('welcome', compact('stats', 'agendas'));
    }

    public function showAgenda(Agenda $agenda)
    {
        if ($agenda->status !== 'active' || $agenda->visibility !== 'public') {
            abort(404);
        }

        $agenda->load(['opdMaster', 'sessions', 'user']);
        return view('agenda.public-detail', compact('agenda'));
    }
}
