<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;


class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

            ActionGroup::make([

                Action::make('pending')
                    ->label('Pending')
                    ->color('gray')
                    ->icon('heroicon-o-clock')
                    ->action(fn() => $this->record->update([
                        'status' => 'pending'
                    ])),

                Action::make('confirm')
                    ->label('Confirm')
                    ->color('info')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn() => $this->record->update([
                        'status' => 'confirmed'
                    ])),

                Action::make('processing')
                    ->label('Processing')
                    ->color('warning')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->action(fn() => $this->record->update([
                        'status' => 'processing'
                    ])),

                Action::make('shipped')
                    ->label('Shipped')
                    ->color('primary')
                    ->icon('heroicon-o-truck')
                    ->action(fn() => $this->record->update([
                        'status' => 'shipped'
                    ])),

                Action::make('delivered')
                    ->label('Delivered')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->action(fn() => $this->record->update([
                        'status' => 'delivered'
                    ])),

                Action::make('cancelled')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(fn() => $this->record->update([
                        'status' => 'cancelled'
                    ])),

            ])
                ->label('Update Status')
                ->icon('heroicon-o-arrow-path'),

            ActionGroup::make([

                Action::make('markPaid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-banknotes')
                    ->action(fn() => $this->record->update([
                        'payment_status' => 'paid'
                    ])),

                Action::make('refund')
                    ->label('Refund Payment')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->requiresConfirmation()
                    ->action(fn() => $this->record->update([
                        'payment_status' => 'refunded'
                    ])),

            ])
                ->label('Payment')
                ->icon('heroicon-o-credit-card')
                ->color('gray')
                ->button()

        ];
    }
}
