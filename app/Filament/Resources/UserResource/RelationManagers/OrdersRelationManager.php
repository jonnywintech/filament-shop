<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'stripe' => 'Stripe',
                        'cod' => 'Cash on Delivery',
                    ])->required(),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ]),
                Forms\Components\ToggleButtons::make('status')
                    ->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'canceled' => 'Canceled'
                    ])
                    ->colors([
                        'new' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'canceled' => 'danger'
                    ])
                    ->icons([
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-o-check-circle',
                        'canceled' => 'heroicon-m-x-circle'
                    ])
                    ->inline()
                    ->default('new')
                    ->required(),
                Forms\Components\Select::make('currency')
                    ->options([
                        'USD' => 'United States Dollar ($)',
                        'EUR' => 'Euro (€)',
                        'GBP' => 'British Pound (£)',
                        'JPY' => 'Japanese Yen (¥)',
                        'CAD' => 'Canadian Dollar (CA$)',
                        'AUD' => 'Australian Dollar (AU$)',
                        'CNY' => 'Chinese Yuan (¥)',
                        'INR' => 'Indian Rupee (₹)',
                        'MYR' => 'Malaysian Ringgit (RM)',
                        'NZD' => 'New Zealand Dollar (NZ$)',
                        'SGD' => 'Singapore Dollar (SGD)',
                        'THB' => 'Thai Baht (฿)',
                        'TWD' => 'Taiwan New Dollar (NT$)',
                    ])
                    ->required()
                    ->default('USD'),
                Forms\Components\Select::make('shipping_method')
                    ->options([
                        'fedex' => 'FedEx',
                        'ups' => 'UPS',
                        'dhl' => 'DHL',
                    ]),
                Forms\Components\MarkdownEditor::make('notes')
                    ->columnSpanFull(),
                Section::make('Order Items')->schema([
                    Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Forms\Components\Select::make('product_id')
                                ->relationship('product', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->reactive()
                                ->columnSpan(4)
                                ->afterStateUpdated(fn ($state, Set $set) => $set('unit_amount', Product::find($state)?->price ?? 0))
                                ->afterStateUpdated(fn ($state, Set $set) => $set('total_amount', Product::find($state)?->price ?? 0)),
                            TextInput::make('quantity')
                                ->numeric()
                                ->required()
                                ->default(1)
                                ->minValue(1)
                                ->columnSpan(2)
                                ->reactive()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $state, Set $set, Get $get): string => $set('total_amount', $get('unit_amount') * $state)),
                            TextInput::make('unit_amount')
                                ->numeric()
                                ->required()
                                ->disabled()
                                ->dehydrated()
                                ->columnSpan(3),
                            TextInput::make('total_amount')
                                ->numeric()
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->columnSpan(3),

                        ])->columns(12),

                    Placeholder::make('grand_total_placeholder')
                        ->label('Grand Total')
                        ->content(function (Get $get, Set $set): int|string {
                            $total = 0;

                            if (!$repeater = $get('items')) {
                                return $total;
                            }

                            foreach ($repeater as $key => $repeater) {
                                $total += $get("items.{$key}.total_amount");
                            }

                            $set('grand_total', $total);

                            return Number::currency($total, $get('currency') ?? 'USD');
                        }),
                    Hidden::make('grand_total'),
                ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-o-check-circle',
                        'canceled' => 'heroicon-m-x-circle'
                    })
                    ->iconPosition('after')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'canceled' => 'danger'
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_method')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
