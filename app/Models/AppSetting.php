<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'app_name',
        'app_logo',
        'login_title',
        'login_description',
    ];

    public function getAppLogoUrlAttribute()
    {
        if ($this->app_logo) {
            return asset('storage/' . $this->app_logo);
        }
        return null;
    }
}
