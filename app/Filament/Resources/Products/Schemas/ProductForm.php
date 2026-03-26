<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                Section::make('Basic Information')
                    ->description('Core product details')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(120)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn(Set $set, ?string $state) =>
                                        $set('slug', Str::slug($state))
                                    ),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(150)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Auto-generated from name – editable if needed')
                                    ->dehydrated(true),
                            ]),
                    ]),

                Section::make('Pricing & Inventory')
                    ->schema([
                        TextInput::make('price')
                            ->label('Regular Price')
                            ->required()
                            ->numeric()
                            ->prefix('Rs')
                            ->minValue(0)
                            ->step(0.01),

                        // TextInput::make('stock')
                        //     ->required()
                        //     ->numeric()
                        //     ->minValue(0)
                        //     ->helperText('0 = out of stock'),
                    ]),

                Section::make('Product Images')
                    ->description('Upload clear, high-quality photos. First image becomes the thumbnail.')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images')
                            ->label('Images')
                            ->minItems(1)
                            ->maxItems(12)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->grid(2)
                            ->defaultItems(1)
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('4:5')
                                    ->directory('products')
                                    ->disk('public')
                                    ->required()
                                    ->imagePreviewHeight('200')
                                    ->maxSize(10240), // ~10MB
                            ])
                            ->columnSpanFull(),
                    ]),
                Section::make('Variants')
                    ->description('Add size, color and stock combinations')
                    ->columnSpanFull()
                    ->schema([

                        Repeater::make('variants')
                            ->relationship('variants')
                            ->minItems(1)
                            ->collapsible()
                            ->cloneable()
                            ->reorderable()
                            ->grid(3)
                            ->schema([

                                Select::make('size')
                                    ->options([
                                        'XXS' => 'XXS',
                                        'XS'  => 'XS',
                                        'S'   => 'S',
                                        'M'   => 'M',
                                        'L'   => 'L',
                                        'XL'  => 'XL',
                                        'XXL' => 'XXL',
                                        '3XL' => '3XL',
                                        '4XL' => '4XL',
                                        '28' => '28',
                                        '30' => '30',
                                        '32' => '32',
                                        '34' => '34',
                                        '36' => '36',
                                        '38' => '38',
                                        '40' => '40',
                                    ])
                                    ->required(),

                                Select::make('product_color_id')
                                    ->label('Color')
                                    ->relationship('productColor', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->native(false),

                                TextInput::make('color')
                                    ->label('Color Name')
                                    ->hidden()
                                    ->required(),
                                TextInput::make('stock')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),


                            ]) // Add these two lines ↓↓↓
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                if (!empty($data['product_color_id'])) {
                                    $color = \App\Models\ProductColor::find($data['product_color_id']);
                                    $data['color'] = $color?->name;
                                }
                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                if (!empty($data['product_color_id'])) {
                                    $color = \App\Models\ProductColor::find($data['product_color_id']);
                                    $data['color'] = $color?->name;
                                }
                                return $data;
                            }),
                    ]),


                Section::make('Description & Status')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('description')
                            ->label('Product Description')
                            ->rows(6)
                            ->columnSpanFull()
                            ->helperText('Use markdown for formatting if needed'),

                        Toggle::make('status')
                            ->label('Active (visible to customers)')
                            ->inline(false)
                            ->default(true),
                    ]),
            ]);
    }
}
