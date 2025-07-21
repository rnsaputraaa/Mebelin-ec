<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderItemsStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    
    protected function getStats(): array
    {
        // Get data
        $totalItems = OrderItem::count();
        $totalRevenue = OrderItem::sum('subtotal');
            $averageItemValue = OrderItem::avg('subtotal') ?? 0;
        $todayItems = OrderItem::whereDate('created_at', today())->count();
        $yesterdayItems = OrderItem::whereDate('created_at', today()->subDay())->count();
        
        
        // Calculate trends
        $itemsTrend = $yesterdayItems > 0 ? (($todayItems - $yesterdayItems) / $yesterdayItems) * 100 : 0;
        $itemsTrendDirection = $itemsTrend >= 0 ? 'increase' : 'decrease';
        $itemsTrendIcon = $itemsTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $itemsTrendColor = $itemsTrend >= 0 ? 'success' : 'danger';

        // Revenue trend (this week vs last week)
        $thisWeekRevenue = OrderItem::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->sum('subtotal');
        
        $lastWeekRevenue = OrderItem::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek()
        ])->sum('subtotal');
        
        $revenueTrend = $lastWeekRevenue > 0 ? (($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100 : 0;
        $revenueTrendDirection = $revenueTrend >= 0 ? 'increase' : 'decrease';
        $revenueTrendIcon = $revenueTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $revenueTrendColor = $revenueTrend >= 0 ? 'success' : 'danger';

        // Most ordered product
        $mostOrderedProductData = OrderItem::selectRaw('id_product, SUM(total) as total_ordered')
            ->groupBy('id_product')
            ->orderByDesc('total_ordered')
            ->first();
        
        $mostOrderedProduct = $mostOrderedProductData ? 
            Product::find($mostOrderedProductData->id_product)?->product_name : 
            'N/A';

        // High value items count (> 1M)
        $highValueItems = OrderItem::where('subtotal', '>', 1000000)->count();

        return [
            Stat::make('Total Order Items', Number::format($totalItems))
                ->description($todayItems . ' items added today')
                ->descriptionIcon($itemsTrendIcon)
                ->color($itemsTrendColor)
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Total Revenue', 'Rp ' . Number::format($totalRevenue))
                ->description(abs($revenueTrend) < 0.1 ? 'No significant change' : 
                    ($revenueTrend >= 0 ? '+' : '') . number_format($revenueTrend, 1) . '% from last week')
                ->descriptionIcon($revenueTrendIcon)
                ->color($revenueTrendColor)
                ->chart([3, 5, 4, 6, 7, 8, 6, 9]),

            Stat::make('Average Item Value', 'Rp ' . Number::format($averageItemValue))
                ->description('Per item purchase value')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info')
                ->chart([4, 3, 5, 6, 4, 7, 5, 6]),

            Stat::make('High Value Items', Number::format($highValueItems))
                ->description('Items > Rp 1M')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->chart([2, 1, 3, 2, 4, 3, 2, 4]),

            Stat::make('Most Ordered Product', $mostOrderedProduct)
                ->description($mostOrderedProductData ? 
                    Number::format($mostOrderedProductData->total_ordered) . ' units ordered' : 
                    'No orders yet')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success')
                ->chart([5, 7, 6, 8, 9, 7, 8, 9]),

            Stat::make('Today\'s Performance', Number::format($todayItems) . ' items')
                ->description($yesterdayItems > 0 ? 
                    (abs($itemsTrend) < 0.1 ? 'Same as yesterday' : 
                        ($itemsTrend >= 0 ? '+' : '') . number_format($itemsTrend, 1) . '% vs yesterday') :
                    'First items today')
                ->descriptionIcon($itemsTrendIcon)
                ->color($itemsTrendColor)
                ->chart([3, 4, 2, 5, 6, 4, 7, 5]),
        ];
    }

    protected function getColumns(): int
    {
        return 3; // 3 columns layout
    }
}