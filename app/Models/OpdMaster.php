<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdMaster extends Model
{
    /** @use HasFactory<\Database\Factories\OpdMasterFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'singkatan',
        'address_opd',
        'catatan',
        'logo_opd',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo_url',
    ];

    /**
     * Get the OPD logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo_opd) {
            return null;
        }

        if (filter_var($this->logo_opd, FILTER_VALIDATE_URL)) {
            return $this->logo_opd;
        }

        return url(\Illuminate\Support\Facades\Storage::url($this->logo_opd));
    }

    /**
     * Get the users for the OPD.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
