<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use Filament\Tables\Table;
use App\Enums\PrimaryColor;
use App\Enums\RecordsPerPage;
use Filament\Facades\Filament;
use App\Enums\TableSortDirection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;


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

        Carbon::macro('format', function ($format) {
            return $this->format($format);
        });

        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament/admin/theme.css');
        });
    }
}
