<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Dokumentasi extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'uuid',
        'opd_master_id',
        'user_id',
        'date',
        'pakaian_id',
        'agenda_id',
        'event_id',
        'judul',
        'keterangan',
        'link_dokumentasi',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function opdMaster()
    {
        return $this->belongsTo(OpdMaster::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pakaian()
    {
        return $this->belongsTo(Pakaian::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
