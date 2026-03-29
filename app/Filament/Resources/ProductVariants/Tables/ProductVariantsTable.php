<?php

namespace App\Filament\Resources\ProductVariants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Illuminate\Database\Eloquent\Builder;

class ProductVariantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('productColor.name')
                    ->label('Color')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('size')
                    ->badge()
                    ->color('info'),

                TextColumn::make('stock')
                    ->label('Initial Stock')
                    ->numeric()
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state == 0 => 'danger',
                        $state <= 5 => 'warning',
                        $state <= 10 => 'info',
                        default => 'success',
                    }),


                TextColumn::make('available_stock')
                    ->label('Available')
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'success'
                    }),
                TextColumn::make('sold')
                    ->getStateUsing(
                        fn($record) =>
                        \App\Models\OrderItem::where('product_id', $record->product_id)
                            ->where('color', $record->color)
                            ->where('size', $record->size)
                            ->sum('quantity')
                    ),
                TextColumn::make('status')
                    ->label('Stock Status')
                    ->badge()
                    ->getStateUsing(fn($record) => match (true) {
                        $record->stock == 0 => 'Out of Stock',
                        $record->stock <= 5 => 'Low Stock',
                        default => 'In Stock',
                    })
                    ->color(fn($state) => match ($state) {
                        'Out of Stock' => 'danger',
                        'Low Stock' => 'warning',
                        'In Stock' => 'success',
                    }),
            ])
            ->filters([
                SelectFilter::make('availability')
                    ->label('Availability')
                    ->options([
                        'available' => 'Available',
                        'low' => 'Low Stock',
                        'out' => 'Out of Stock',
                    ])
                    ->query(function (Builder $query, array $data) {

                        return $query->when($data['value'] === 'out_stock', function ($q) {
                            $q->where('stock', '<=', 0);
                        })
                            ->when($data['value'] === 'low_stock', function ($q) {
                                $q->whereBetween('stock', [1, 5]);
                            })
                            ->when($data['value'] === 'in_stock', function ($q) {
                                $q->where('stock', '>', 5);
                            });
                    })
            ])
            ->recordActions([
                // ViewAction::make(),
                Action::make('updateStock')
                    ->label('Update Stock')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->form([

                        Grid::make(3)
                            ->schema([

                                Placeholder::make('current')
                                    ->label('Current')
                                    ->content(fn($record) => $record->stock),

                                Placeholder::make('available')
                                    ->label('Available')
                                    ->content(fn($record) => $record->available_stock),

                                Placeholder::make('sold')
                                    ->label('Sold')
                                    ->content(
                                        fn($record) =>
                                        \App\Models\OrderItem::where(
                                            'product_id',
                                            $record->id
                                        )->sum('quantity')
                                    ),
                            ]),

                        TextInput::make('adjust')
                            ->label('Adjust Quantity')
                            ->numeric()
                            ->default(0)
                            ->prefix('±')
                            ->helperText('Add or remove stock'),

                        Placeholder::make('new_stock')
                            ->label('New Stock')
                            ->content(
                                fn($record, $get) =>
                                $record->stock + ($get('adjust') ?? 0)
                            )
                            ->extraAttributes([
                                'class' => 'text-lg font-bold'
                            ]),

                    ])
                    ->action(function ($record, array $data) {

                        $newStock = $record->stock + $data['adjust'];

                        if ($newStock < 0) {
                            $newStock = 0;
                        }

                        $record->update([
                            'stock' => $newStock
                        ]);
                    })
                    ->modalHeading('Update Inventory')
                    ->modalSubmitActionLabel('Update Stock')
            ])
            ->defaultGroup('product.name')
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
