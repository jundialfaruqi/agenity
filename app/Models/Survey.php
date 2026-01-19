<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'uuid',
        'slug',
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

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($survey) {
            // Generate UUID if empty
            if (empty($survey->uuid)) {
                $survey->uuid = (string) Str::uuid();
            }

            // Generate slug if empty
            if (empty($survey->slug)) {
                $survey->slug = Str::slug($survey->title) . '-' . Str::lower(Str::random(5));
            }
        });
    }

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
