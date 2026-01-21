<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriPakaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function pakaians()
    {
        return $this->hasMany(Pakaian::class);
    }
}
