<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Users';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
        'datasets' => [
            [
                'label' => 'User Monthly Created',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'backgroundColor' => '#36A2EB',
                'borderColor' => '#9BD0F5',
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => Carbon::createFromFormat('Y-m', $value->date)->format('M'))
    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
