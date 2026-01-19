<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'uuid',
        'master_opd_id',
        'user_id',
        'title',
        'slug',
        'jenis_event',
        'mode',
        'date',
        'start_time',
        'end_time',
        'location',
        'link_streaming_youtube',
        'link_lainnya',
        'ket_link_lainnya',
        'content',
        'catatan',
        'status',
    ];

    protected $casts = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function opdMaster()
    {
        return $this->belongsTo(OpdMaster::class, 'master_opd_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFirstImageAttribute()
    {
        if (empty($this->content)) {
            return null;
        }

        preg_match('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $this->content, $matches);
        return $matches[1] ?? null;
    }
}
