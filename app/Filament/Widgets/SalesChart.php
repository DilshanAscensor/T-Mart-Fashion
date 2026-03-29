<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Sales Overview';
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '500px';
    protected function getData(): array
    {
        $data = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->pluck('total', 'date');

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
