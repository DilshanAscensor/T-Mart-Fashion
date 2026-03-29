<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Revenue',
                'LKR ' . number_format(
                    Order::where('payment_status', 'paid')->sum('total')
                )
            )
                ->description('Total Paid Orders')
                ->color('success')
                ->chart([3, 5, 4, 6, 8, 7, 9])
                ->icon('heroicon-o-banknotes'),

            Stat::make('Orders', Order::count())
                ->description('Total Orders')
                ->color('primary')
                ->chart([1, 2, 3, 2, 4, 3, 5])
                ->icon('heroicon-o-shopping-bag'),

            Stat::make(
                'COD Orders',
                Order::where('payment_method', 'cod')->count()
            )
                ->description('Cash On Delivery Orders')
                ->color('warning')
                ->chart([2, 1, 3, 4, 3, 5, 4])
                ->icon('heroicon-o-truck'),

            Stat::make(
                'Card Payments',
                Order::where('payment_method', 'card')->count()
            )
                ->description('Online Pay Orders')
                ->color('success')
                ->chart([5, 3, 4, 6, 5, 7, 8])
                ->icon('heroicon-o-credit-card'),

            Stat::make(
                'Pending',
                Order::where('status', 'pending')->count()
            )
                ->description('Order Status')
                ->color('gray')
                ->chart([1, 2, 1, 3, 2, 1, 2]),

            Stat::make(
                'Processing',
                Order::where('status', 'processing')->count()
            )
                ->description('Order Status')
                ->color('warning')
                ->chart([2, 3, 2, 4, 3, 5, 4]),

            Stat::make(
                'Shipped',
                Order::where('status', 'shipped')->count()
            )
                ->description('Order Status')
                ->color('info')
                ->chart([1, 3, 2, 4, 5, 4, 6]),

            Stat::make(
                'Delivered',
                Order::where('status', 'delivered')->count()
            )
                ->description('Order Status')
                ->color('success')
                ->chart([3, 4, 5, 6, 7, 6, 8]),

            Stat::make(
                'Cancelled',
                Order::where('status', 'cancelled')->count()
            )
                ->description('Order Status')
                ->color('danger')
                ->chart([0, 1, 0, 2, 1, 0, 1]),

        ];
    }
}
