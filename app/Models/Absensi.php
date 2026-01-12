<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_session_id',
        'name',
        'nip_nik',
        'handphone',
        'asal_daerah',
        'master_opd_id',
        'asal_instansi',
        'jabatan_pekerjaan',
        'ttd_path',
        'checkin_time',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'checkin_time' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(AgendaSession::class, 'agenda_session_id');
    }

    public function opdMaster()
    {
        return $this->belongsTo(OpdMaster::class, 'master_opd_id');
    }
}
