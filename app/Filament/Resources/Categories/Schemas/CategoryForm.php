<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Category;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        if (! $get('slug')) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('description'),
                TextInput::make('slug')
                    ->required()
                    ->unique(Category::class, 'slug', ignoreRecord: true),
                FileUpload::make('image')
                    ->label('Images')
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->required()
                    ->columnSpan(1),
                Toggle::make('status')
                    ->default(true)
                    ->required(),
            ]);
    }
}
