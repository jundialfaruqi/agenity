<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Services\AgendaService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request, AgendaService $service)
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
            ->paginate(12)
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

        return view('welcome', compact('stats', 'agendas', 'currentFilter'));
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
