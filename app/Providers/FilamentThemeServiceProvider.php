<?php

namespace App\Providers;

use App\Enums\Font;
use App\Enums\PrimaryColor;
use Filament\Panel;
use App\Models\Appearance;
use App\Enums\RecordsPerPage;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use App\Providers\Filament\AdminPanelProvider;

class FilamentThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FilamentColor::register(function () {
        $user = auth()->user();

            if (!$user) {
                Filament::getPanel('admin')
                ->font(Font::DEFAULT);
                return ['primary' => Color::Amber]; // Default color if no user is authenticated
            }

            $appearance = Appearance::firstOrCreate(['user_id' => $user->id]);
            $primaryColor = $appearance?->primary_color ?? PrimaryColor::Emerald;
            $font_family = $appearance?->font?->getLabel() ?? Font::DEFAULT;
            Filament::getPanel('company')
            ->font($font_family);

            return [
                'primary' => $primaryColor->getColor(),
            ];
        });

    }
}
