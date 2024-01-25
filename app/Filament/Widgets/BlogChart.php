<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Blog;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class BlogChart extends ChartWidget
{
    protected static ?string $heading = 'Blogs';

    protected function getData(): array
    {
        $data = Trend::model(Blog::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
        'datasets' => [
            [
                'label' => 'Blog Monthly Created',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'backgroundColor' => '#C32ACD',
                'borderColor' => '#9BD0F5',
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => Carbon::createFromFormat('Y-m', $value->date)->format('M')),
    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
