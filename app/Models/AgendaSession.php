<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_id',
        'session_name',
        'session_type',
        'token',
        'qr_code_path',
        'start_at',
        'end_at',
        'is_active',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
