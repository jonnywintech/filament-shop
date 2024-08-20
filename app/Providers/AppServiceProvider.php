<?php

namespace App\Providers;

use App\Models\User;
use Filament\Tables\Table;
use App\Enums\PrimaryColor;
use App\Enums\RecordsPerPage;
use App\Enums\TableSortDirection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use Filament\Facades\Filament;


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

        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament/admin/theme.css');

        });
    }
}
