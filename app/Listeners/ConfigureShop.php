<?php

namespace App\Listeners;

use App\Events\ShopConfigured;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Filament\Tables\Table;
use App\Enums\PrimaryColor;
use App\Enums\RecordsPerPage;
use App\Enums\TableSortDirection;
use Filament\Support\Facades\FilamentColor;
class ConfigureShop
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ShopConfigured $event): void
    {
        $paginationPageOptions = RecordsPerPage::caseValues();
        $default_pagination_option = $event->appearance->records_per_page->value ?? RecordsPerPage::DEFAULT;
        $default_sort =  $event->appearance->table_sort_direction ?? TableSortDirection::DEFAULT;
        $defaultPrimaryColor = $event->appearance->primary_color ?? PrimaryColor::from(PrimaryColor::DEFAULT);

        Table::configureUsing(static function (Table $table) use ($paginationPageOptions, $default_sort, $default_pagination_option): void {

            $table
                ->paginationPageOptions($paginationPageOptions)
                ->defaultSort(column: 'id', direction: $default_sort)
                ->defaultPaginationPageOption($default_pagination_option);
        }, isImportant: true);

        FilamentColor::register([
            'primary' => $defaultPrimaryColor->getColor(),
        ]);
    }
}
