<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected array|string|int $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderResource::getEloquentQuery())
                ->defaultPaginationPageOption(5)
                ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                ->searchable()
                ->sortable(),
                TextColumn::make('grand_total')
                    ->money(fn(Model $query) => $query->currency)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_method')
                ->searchable()
                ->sortable(),
                TextColumn::make('payment_status')
                ->searchable()
                ->sortable(),
                TextColumn::make('created_at')
                ->label('Order Date')
                ->dateTime(),
            ])
            ->actions([
                Action::make('View')
                ->url( fn(Order $record) => OrderResource::getUrl('view', compact('record')))
                ->icon('heroicon-o-eye'),
            ]);
    }
}
