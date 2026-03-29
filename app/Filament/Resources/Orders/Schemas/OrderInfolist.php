<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Order Overview')
                    ->icon('heroicon-o-shopping-bag')
                    ->columns(4)
                    ->schema([

                        TextEntry::make('order_number')
                            ->label('Order #')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->icon('heroicon-o-hashtag'),

                        TextEntry::make('status')
                            ->badge()
                            ->label('Status')
                            ->icon('heroicon-o-signal')
                            ->color(fn($state) => match ($state) {
                                'pending' => 'gray',
                                'confirmed' => 'info',
                                'processing' => 'warning',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            }),

                        TextEntry::make('payment_method')
                            ->badge()
                            ->label('Payment')
                            ->icon('heroicon-o-credit-card')
                            ->color(fn($state) => match ($state) {
                                'cod' => 'gray',
                                'card' => 'success',
                            }),

                        TextEntry::make('payment_status')
                            ->badge()
                            ->label('Payment Status')
                            ->icon('heroicon-o-banknotes')
                            ->color(fn($state) => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'failed' => 'danger',
                                'refunded' => 'gray',
                            }),

                    ]),


                Section::make('Customer')
                    ->icon('heroicon-o-user')
                    ->columns(3)
                    ->schema([

                        TextEntry::make('full_name')
                            ->label('Customer Name')
                            ->weight(FontWeight::Medium),

                        TextEntry::make('email')
                            ->icon('heroicon-o-envelope'),

                        TextEntry::make('phone')
                            ->icon('heroicon-o-phone'),

                    ]),


                Section::make('Shipping Address')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([

                        TextEntry::make('address1')
                            ->columnSpanFull(),

                        TextEntry::make('address2')
                            ->columnSpanFull(),

                        TextEntry::make('city'),
                        TextEntry::make('district'),

                        TextEntry::make('postal_code')
                            ->badge()
                            ->color('gray'),

                    ]),


                Section::make('Order Summary')
                    ->icon('heroicon-o-calculator')
                    ->columns(5)
                    ->schema([

                        TextEntry::make('subtotal')
                            ->money('LKR')
                            ->label('Subtotal'),

                        TextEntry::make('shipping')
                            ->money('LKR')
                            ->label('Shipping'),

                        TextEntry::make('tax')
                            ->money('LKR')
                            ->label('Tax'),

                        TextEntry::make('discount')
                            ->money('LKR')
                            ->label('Discount')
                            ->color('danger'),

                        TextEntry::make('total')
                            ->money('LKR')
                            ->badge()
                            ->weight(FontWeight::Bold)
                            ->color('success'),

                    ]),
            ]);
    }
}
