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
