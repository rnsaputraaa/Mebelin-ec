<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class OrdersChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Orders Trend';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Get data for last 30 days
        $days = collect();
        $orderCounts = collect();
        $revenues = collect();

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayOrders = Order::whereDate('tanggal_order', $date)->count();
            $dayRevenue = Order::whereDate('tanggal_order', $date)
                ->where('status_order', '!=', 'cancelled')
                ->sum('total_harga');

            $days->push($date->format('M j'));
            $orderCounts->push($dayOrders);
            $revenues->push($dayRevenue / 1000000); // Convert to millions
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders Count',
                    'data' => $orderCounts->toArray(),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Revenue (Millions)',
                    'data' => $revenues->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $days->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Date',
                    ],
                ],
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Orders Count',
                    ],
                    'beginAtZero' => true,
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (Millions Rp)',
                    ],
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            let label = context.dataset.label || "";
                            if (label) {
                                label += ": ";
                            }
                            if (context.datasetIndex === 1) {
                                label += "Rp " + (context.parsed.y * 1000000).toLocaleString("id-ID");
                            } else {
                                label += context.parsed.y;
                            }
                            return label;
                        }',
                    ],
                ],
            ],
        ];
    }
}

class OrdersStatusChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Orders by Status';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $statuses = Order::selectRaw('status_order, COUNT(*) as count')
            ->groupBy('status_order')
            ->pluck('count', 'status_order')
            ->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($statuses),
                    'backgroundColor' => [
                        '#6B7280', // pending - gray
                        '#F59E0B', // processing - yellow
                        '#3B82F6', // shipped - blue
                        '#10B981', // delivered - green
                        '#EF4444', // cancelled - red
                    ],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => array_map('ucfirst', array_keys($statuses)),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ": " + context.parsed + " (" + percentage + "%)";
                        }',
                    ],
                ],
            ],
        ];
    }
}

class MonthlyRevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue Trend';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $months = collect();
        $revenues = collect();

        // Get last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthRevenue = Order::whereMonth('tanggal_order', $date->month)
                ->whereYear('tanggal_order', $date->year)
                ->where('status_order', '!=', 'cancelled')
                ->sum('total_harga');

            $months->push($date->format('M Y'));
            $revenues->push($monthRevenue / 1000000); // Convert to millions
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (Millions Rp)',
                    'data' => $revenues->toArray(),
                    'borderColor' => '#8B5CF6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Month',
                    ],
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (Millions Rp)',
                    ],
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return "Revenue: Rp " + (context.parsed.y * 1000000).toLocaleString("id-ID");
                        }',
                    ],
                ],
            ],
        ];
    }
}