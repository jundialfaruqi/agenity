<?php

namespace App\Services;

use App\Models\Agenda;
use App\Models\Event;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationService
{
    public function getAttentionRequiredItems()
    {
        if (!Auth::check()) {
            return collect();
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $notifications = collect();

        // 1. Agendas
        $agendaQuery = Agenda::query();
        if ($user->hasRole('admin-opd')) {
            $agendaQuery->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('master_opd_id', $user->opd_master_id);
            });
        } elseif (!$user->hasRole('super-admin')) {
            $agendaQuery->where('user_id', $user->id);
        }

        $agendas = $agendaQuery->where(function ($q) use ($today) {
            $q->where('status', 'draft')
                ->orWhere(function ($sq) use ($today) {
                    $sq->where('status', 'active')
                        ->where('date', '<', $today);
                });
        })->get();

        foreach ($agendas as $agenda) {
            $type = $agenda->status === 'draft' ? 'Draft' : 'Expired';
            $notifications->push([
                'id' => $agenda->id,
                'title' => $agenda->title,
                'category' => 'Agenda',
                'type' => $type,
                'message' => $type === 'Draft' ? 'Agenda masih dalam status draft.' : 'Agenda sudah lewat namun masih berstatus aktif.',
                'url' => route('agenda.edit', $agenda->id),
                'icon' => 'calendar',
                'color' => $type === 'Draft' ? 'warning' : 'error',
                'date' => $agenda->date,
            ]);
        }

        // 2. Events
        $eventQuery = Event::query();
        if ($user->hasRole('admin-opd')) {
            $eventQuery->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('master_opd_id', $user->opd_master_id);
            });
        } elseif (!$user->hasRole('super-admin')) {
            $eventQuery->where('user_id', $user->id);
        }

        $events = $eventQuery->where(function ($q) use ($today) {
            $q->where('status', 'draft') // Adding draft too for consistency
                ->orWhere(function ($sq) use ($today) {
                    $sq->where('status', 'active')
                        ->where('date', '<', $today);
                });
        })->get();

        foreach ($events as $event) {
            $type = $event->status === 'draft' ? 'Draft' : 'Expired';
            $notifications->push([
                'id' => $event->id,
                'title' => $event->title,
                'category' => 'Event',
                'type' => $type,
                'message' => $type === 'Draft' ? 'Event masih dalam status draft.' : 'Event sudah lewat namun masih berstatus aktif.',
                'url' => route('event.edit', $event->id),
                'icon' => 'ticket',
                'color' => $type === 'Draft' ? 'warning' : 'error',
                'date' => $event->date,
            ]);
        }

        // 3. Surveys
        $surveyQuery = Survey::withCount('respondents');
        if ($user->hasRole('admin-opd')) {
            $surveyQuery->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhere('opd_id', $user->opd_master_id);
            });
        } elseif (!$user->hasRole('super-admin')) {
            $surveyQuery->where('created_by', $user->id);
        }

        $surveys = $surveyQuery->where('is_active', true)
            ->get()
            ->filter(function ($survey) use ($today) {
                $isExpired = $survey->end_date && $survey->end_date->toDateString() < $today;
                $limitReached = $survey->max_respondents > 0 && $survey->respondents_count >= $survey->max_respondents;
                return $isExpired || $limitReached;
            });

        foreach ($surveys as $survey) {
            $isExpired = $survey->end_date && $survey->end_date->toDateString() < $today;
            $type = $isExpired ? 'Expired' : 'Limit Reached';
            $notifications->push([
                'id' => $survey->id,
                'title' => $survey->title,
                'category' => 'Survei',
                'type' => $type,
                'message' => $isExpired ? 'Batas waktu survei sudah berakhir.' : 'Kuota responden survei sudah terpenuhi.',
                'url' => route('survey.edit', $survey->id),
                'icon' => 'clipboard-document-list',
                'color' => 'error',
                'date' => $survey->end_date ? $survey->end_date->toDateString() : null,
            ]);
        }

        return $notifications->sortByDesc('date');
    }
}
