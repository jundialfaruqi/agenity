<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'max_respondents',
        'is_active',
        'visibility',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function opd()
    {
        return $this->belongsTo(OpdMaster::class, 'opd_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class)->orderBy('order');
    }

    public function respondents()
    {
        return $this->hasMany(SurveyRespondent::class);
    }

    public function tokens()
    {
        return $this->hasMany(SurveyToken::class);
    }
}
