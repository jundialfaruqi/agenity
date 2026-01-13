<?php

namespace App\Http\Controllers;

use App\Services\AgendaService;
use App\Models\User;
use App\Models\OpdMaster;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request, AgendaService $service)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $agendaStats = $service->getStats();

        $type = $request->query('type', '10_months'); // month, 10_months, year, range
        $startYear = (int) $request->query('start_year', Carbon::now()->subYears(5)->year);
        $endYear = (int) $request->query('end_year', Carbon::now()->year);

        // Additional stats for dashboard
        $stats = [
            'total_agenda' => $agendaStats['total'],
            'active_agenda' => $agendaStats['active'],
            'total_opd' => OpdMaster::count(),
            'total_users' => User::count(),
            'total_absensi' => Absensi::count(),
        ];

        $chartData = [];
        $labels = [];
        $title = "Statistik Agenda";

        if ($type === 'month') {
            $title = "Statistik Agenda (Bulan Ini)";
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('d/m');
                $chartData[] = $this->getAgendaCount($user, $date->year, $date->month, $date->day);
            }
        } elseif ($type === 'year') {
            $selectedYear = (int) $request->query('year', Carbon::now()->year);
            $title = "Statistik Agenda (Tahun $selectedYear)";
            for ($m = 1; $m <= 12; $m++) {
                $date = Carbon::create($selectedYear, $m, 1);
                $labels[] = $date->format('M');
                $chartData[] = $this->getAgendaCount($user, $selectedYear, $m);
            }
        } elseif ($type === 'range') {
            $title = "Perbandingan Agenda ($startYear - $endYear)";
            for ($y = $startYear; $y <= $endYear; $y++) {
                $labels[] = (string) $y;
                $chartData[] = $this->getAgendaCount($user, $y);
            }
        } else {
            // Default 10 Months
            $title = "Statistik Agenda (10 Bulan Terakhir)";
            for ($i = 9; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $labels[] = $month->format('M Y');
                $chartData[] = $this->getAgendaCount($user, $month->year, $month->month);
            }
        }

        // Calculate max for percentage scaling in view
        $maxVal = (!empty($chartData) ? max($chartData) : 0) ?: 1;
        $chartDataScaled = array_map(fn($v) => ($v / $maxVal) * 100, $chartData);

        // Trend calculation (current vs previous period)
        $currentVal = end($chartData);
        $prevVal = count($chartData) > 1 ? $chartData[count($chartData) - 2] : 0;
        $trend = $prevVal > 0 ? (($currentVal - $prevVal) / $prevVal) * 100 : 0;

        // Years for range selection
        $availableYears = range(Carbon::now()->year, 2020);

        // OPD Statistics: Top 10 OPD with most agendas
        $opdStats = \App\Models\Agenda::select('master_opd_id', DB::raw('count(*) as total'))
            ->with('opdMaster:id,name')
            ->groupBy('master_opd_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $opdLabels = $opdStats->map(fn($item) => $item->opdMaster->name ?? 'N/A')->toArray();
        $opdChartData = $opdStats->pluck('total')->toArray();
        $maxOpdVal = (!empty($opdChartData) ? max($opdChartData) : 0) ?: 1;
        $opdChartDataScaled = array_map(fn($v) => ($v / $maxOpdVal) * 100, $opdChartData);

        // Upcoming Agendas
        $agendaFilter = $request->query('agenda_filter', '7_days'); // 7_days or this_month
        $upcomingAgendasQuery = \App\Models\Agenda::with(['opdMaster', 'user'])
            ->where('status', 'active');

        if ($agendaFilter === 'this_month') {
            $upcomingAgendasQuery->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year);
        } else {
            $upcomingAgendasQuery->whereBetween('date', [
                Carbon::now()->toDateString(),
                Carbon::now()->addDays(6)->toDateString()
            ]);
        }

        $upcomingAgendas = $upcomingAgendasQuery->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(3, ['*'], 'agendas_page');

        // Map agendas to add view-specific attributes
        $upcomingAgendas->getCollection()->transform(function ($agenda) {
            // Status Badge Class
            $agenda->status_badge_class = match ($agenda->status) {
                'active' => 'badge-success',
                'draft' => 'badge-warning',
                'finished' => 'badge-neutral',
                default => 'badge-ghost',
            };

            // Time Status Logic
            $now = Carbon::now('Asia/Jakarta')->startOfDay();
            $agendaDate = Carbon::parse($agenda->date, 'Asia/Jakarta')->startOfDay();
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

            // Visibility Logic
            $agenda->visibility_status = [
                'label' => ucfirst($agenda->visibility),
                'class' => match ($agenda->visibility) {
                    'public' => 'badge-primary',
                    'private' => 'badge-error',
                    default => 'badge-ghost',
                }
            ];

            return $agenda;
        });

        // Line Chart Data: Agenda (Last 7 days)
        $lineChartData = [
            'agenda' => [],
            'absensi' => [],
            'labels' => [],
            'full_labels' => []
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $lineChartData['labels'][] = $date->format('d/m');
            $lineChartData['full_labels'][] = $date->translatedFormat('d M');

            // Agenda count (All Status)
            $agendaCount = \App\Models\Agenda::whereDate('date', $date->toDateString())
                ->count();
            $lineChartData['agenda'][] = $agendaCount;
        }

        // Generate SVG points for the line chart (7 points, width 300, height 100)
        $maxLineVal = (!empty($lineChartData['agenda']) ? max($lineChartData['agenda']) : 0) ?: 1;

        $getPoints = function ($data) use ($maxLineVal) {
            $points = "";
            foreach ($data as $i => $val) {
                $x = $i * (300 / 6);
                $y = 100 - (($val / $maxLineVal) * 60 + 20); // Scale to fit 20-80 range to leave space for labels
                $points .= ($i == 0 ? "M" : " L") . "$x,$y";
            }
            return $points;
        };

        $chartDataRaw = [];
        foreach ($lineChartData['agenda'] as $i => $val) {
            $x = $i * (300 / 6);
            $y = 100 - (($val / $maxLineVal) * 60 + 20);
            $chartDataRaw[] = [
                'x' => $x,
                'y' => $y,
                'value' => $val,
                'label' => $lineChartData['full_labels'][$i]
            ];
        }

        $agendaPoints = $getPoints($lineChartData['agenda']);

        // Quick Stats for Line Chart
        $totalAgendaLast7Days = array_sum($lineChartData['agenda']);

        return view('dashboard.index', compact(
            'stats',
            'chartData',
            'chartDataScaled',
            'labels',
            'trend',
            'type',
            'title',
            'startYear',
            'endYear',
            'availableYears',
            'agendaPoints',
            'totalAgendaLast7Days',
            'chartDataRaw',
            'opdLabels',
            'opdChartData',
            'opdChartDataScaled',
            'upcomingAgendas',
            'agendaFilter'
        ));
    }

    private function getAgendaCount($user, $year, $month = null, $day = null)
    {
        $query = \App\Models\Agenda::whereYear('date', $year);

        if ($month) {
            $query->whereMonth('date', $month);
        }
        if ($day) {
            $query->whereDay('date', $day);
        }

        return $query->count();
    }
}
