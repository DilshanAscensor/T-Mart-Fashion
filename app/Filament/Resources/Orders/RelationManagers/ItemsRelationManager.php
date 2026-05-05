<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Order Items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('product.images')) // Eager loading
            ->recordTitleAttribute('product_name')
            ->columns([
                ImageColumn::make('first_image')
                    ->label('Image')
                    ->disk('public')
                    ->width(70)
                    ->height(70)
                    ->square()
                    ->alignCenter()
                    ->extraImgAttributes([
                        'class' => 'object-cover rounded-lg shadow-sm cursor-pointer'
                    ]),

                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('color')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('size')
                    ->badge()
                    ->color('info'),

                TextColumn::make('quantity')
                    ->numeric()
                    ->alignCenter(),

                TextColumn::make('price')
                    ->money('LKR')
                    ->alignEnd(),

                TextColumn::make('total')
                    ->money('LKR')
                    ->alignEnd(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
