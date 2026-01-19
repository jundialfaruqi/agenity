<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventService
{
    public function listEvents(?string $search = null, ?string $status = null, int $perPage = 10)
    {
        $query = Event::query()->with(['opdMaster', 'user']);

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
                    ->orWhere('jenis_event', 'like', '%' . $search . '%')
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
                    ->where('date', '<', Carbon::now()->toDateString());
            } else {
                $query->where('status', $status);
            }
        }

        return $query->orderBy('date', 'desc')->orderBy('start_time', 'desc')->paginate($perPage);
    }

    public function getStats(): array
    {
        $query = Event::query();

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
                ->where('date', '<', Carbon::now()->toDateString())
                ->count(),
        ];

        return $stats;
    }

    public function createEvent(array $data): Event
    {
        $data['slug'] = $this->generateUniqueSlug($data['title'], $data['date']);
        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data): Event
    {
        // Slug is permanent, do not update it here
        $event->update($data);
        return $event;
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }

    public function suggest(string $q): \Illuminate\Support\Collection
    {
        $query = Event::query()->with(['opdMaster']);

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
                ->orWhere('jenis_event', 'like', '%' . $q . '%')
                ->orWhere('location', 'like', '%' . $q . '%')
                ->orWhereHas('opdMaster', function ($oq) use ($q) {
                    $oq->where('name', 'like', '%' . $q . '%')
                        ->orWhere('singkatan', 'like', '%' . $q . '%');
                });
        })
            ->limit(5)
            ->get()
            ->map(function ($e) {
                return [
                    'title' => $e->title,
                    'jenis' => $e->jenis_event,
                    'opd' => $e->opdMaster?->singkatan ?? $e->opdMaster?->name ?? '',
                    'status' => $e->status,
                ];
            });
    }

    /**
     * Generate a unique slug for Event based on date and title.
     * Format: {d-m-Y}/{slugified-title}
     */
    protected function generateUniqueSlug(string $title, string $date, ?int $excludeId = null): string
    {
        $formattedDate = \Carbon\Carbon::parse($date)->format('j-n-Y');
        $baseSlug = \Illuminate\Support\Str::slug($title);
        $slug = $formattedDate . '/' . $baseSlug;

        // Check for uniqueness
        $count = 1;
        while (Event::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $formattedDate . '/' . $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
