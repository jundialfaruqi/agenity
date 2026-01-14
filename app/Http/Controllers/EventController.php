<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\OpdMaster;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request, EventService $service)
    {
        $q = (string) $request->query('q', '');
        $status = (string) $request->query('status', '');
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $events = $service->listEvents($q !== '' ? $q : null, $status !== '' ? $status : null, $perPage);

        // Map events to add view-specific attributes
        $events->getCollection()->transform(function ($event) {
            // Status Badge Class
            $event->status_badge_class = match ($event->status) {
                'active' => 'badge-success',
                'draft' => 'badge-warning',
                'finished' => 'badge-neutral',
                default => 'badge-ghost',
            };

            // Time Status Logic
            $now = Carbon::now('Asia/Jakarta')->startOfDay();
            $eventDate = Carbon::parse($event->date, 'Asia/Jakarta')->startOfDay();
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
                    'text_class' => 'text-white'
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
                    'text_class' => 'text-white'
                ];
            }
            $event->time_status = $timeStatus;

            return $event;
        });

        $stats = $service->getStats();

        return view('event.index', compact('events', 'q', 'status', 'stats'));
    }

    public function create()
    {
        $opds = OpdMaster::orderBy('name')->get();
        return view('event.create', compact('opds'));
    }

    public function store(Request $request, EventService $service): RedirectResponse
    {
        $validated = $request->validate([
            'master_opd_id' => 'required|exists:opd_masters,id',
            'title' => 'required|string|max:255',
            'jenis_event' => 'required|string|max:255',
            'mode' => 'required|in:online,offline,hybrid',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string|max:255',
            'link_streaming_youtube' => 'nullable|url',
            'link_lainnya' => 'nullable|url',
            'ket_link_lainnya' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:draft,active,finished',
        ]);

        $validated['user_id'] = Auth::id();

        try {
            $service->createEvent($validated);
            return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($event->user_id !== $user->id && $event->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke event ini.');
            }
        }

        $opds = OpdMaster::orderBy('name')->get();
        return view('event.edit', compact('event', 'opds'));
    }

    public function update(Request $request, EventService $service, Event $event): RedirectResponse
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($event->user_id !== $user->id && $event->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke event ini.');
            }
        }

        $validated = $request->validate([
            'master_opd_id' => 'required|exists:opd_masters,id',
            'title' => 'required|string|max:255',
            'jenis_event' => 'required|string|max:255',
            'mode' => 'required|in:online,offline,hybrid',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string|max:255',
            'link_streaming_youtube' => 'nullable|url',
            'link_lainnya' => 'nullable|url',
            'ket_link_lainnya' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:draft,active,finished',
        ]);

        try {
            $service->updateEvent($event, $validated);
            return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Event $event): RedirectResponse
    {
        // Authorization for admin-opd
        if (Auth::user()->hasRole('admin-opd')) {
            $user = Auth::user();
            if ($event->user_id !== $user->id && $event->master_opd_id !== $user->opd_master_id) {
                abort(403, 'Anda tidak memiliki akses ke event ini.');
            }
        }

        try {
            $event->delete();
            return redirect()->route('event.index')->with('success', 'Event berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->route('event.index')->with('error', 'Gagal menghapus event: ' . $e->getMessage());
        }
    }

    public function suggest(Request $request, EventService $service)
    {
        $q = (string) $request->query('q', '');
        if ($q === '') {
            return response()->json(['data' => []]);
        }
        $suggestions = $service->suggest($q);
        return response()->json(['data' => $suggestions]);
    }
}
