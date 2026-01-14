<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'token',
        'is_used',
        'expired_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'expired_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
