<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pakaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'kategori_pakaian_id',
        'contoh_pakaian',
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

    public function kategoriPakaian()
    {
        return $this->belongsTo(KategoriPakaian::class);
    }
}
