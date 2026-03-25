<?php

namespace App\Filament\Resources\ProductColors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductColorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->label('Color')
                    ->required(),
                TextInput::make('color_code')
            ]);
    }
}
