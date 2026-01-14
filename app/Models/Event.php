<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_opd_id',
        'user_id',
        'title',
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
