<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

use App\Models\AppSetting;
use App\Http\View\Composers\DashboardHeaderComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set locale to Indonesia
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });

        // Share app settings with all views
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            if (Schema::hasTable('app_settings')) {
                View::share('appSetting', AppSetting::find(1));
            }
        }

        // Dashboard Header Notifications
        View::composer('components.dashboard.header', DashboardHeaderComposer::class);
    }
}
