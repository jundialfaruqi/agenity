<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'respondent_id',
        'question_id',
        'option_id',
        'answer_text',
        'score',
    ];

    public function respondent()
    {
        return $this->belongsTo(SurveyRespondent::class, 'respondent_id');
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    public function option()
    {
        return $this->belongsTo(SurveyOption::class, 'option_id');
    }
}
