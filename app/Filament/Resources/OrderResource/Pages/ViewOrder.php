<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OrderResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Process Order')
            ->url(fn(Order $order) => route('generate.pdf', $order->id))
            ->openUrlInNewTab(),
            Actions\EditAction::make(),
        ];
    }
}
