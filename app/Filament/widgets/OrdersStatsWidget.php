<?php

namespace App\Filament\Widgets;  

use App\Models\Order;
use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrdersStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    
    protected function getStats(): array
    {
        // Get basic statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status_order', 'pending')->count();
        $processingOrders = Order::where('status_order', 'processing')->count();
        $deliveredOrders = Order::where('status_order', 'delivered')->count();
        $cancelledOrders = Order::where('status_order', 'cancelled')->count();
        
        // Revenue calculations
        $totalRevenue = Order::where('status_order', '!=', 'cancelled')->sum('total_harga');
        $todayRevenue = Order::whereDate('tanggal_order', today())
            ->where('status_order', '!=', 'cancelled')
            ->sum('total_harga');
        $yesterdayRevenue = Order::whereDate('tanggal_order', now()->subDay())
            ->where('status_order', '!=', 'cancelled')
            ->sum('total_harga');

        // Calculate trends
        $revenueTrend = $yesterdayRevenue > 0 ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100 : 0;
        $revenueTrendDirection = $revenueTrend >= 0 ? 'increase' : 'decrease';
        $revenueTrendIcon = $revenueTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $revenueTrendColor = $revenueTrend >= 0 ? 'success' : 'danger';

        // Order trends (today vs yesterday)
        $todayOrders = Order::whereDate('tanggal_order', today())->count();
        $yesterdayOrders = Order::whereDate('tanggal_order', now()->subDay())->count();
        $ordersTrend = $yesterdayOrders > 0 ? (($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100 : 0;
        $ordersTrendIcon = $ordersTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $ordersTrendColor = $ordersTrend >= 0 ? 'success' : 'danger';

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // This month vs last month
        $thisMonthRevenue = Order::whereMonth('tanggal_order', now()->month)
            ->whereYear('tanggal_order', now()->year)
            ->where('status_order', '!=', 'cancelled')
            ->sum('total_harga');
        
        $lastMonthRevenue = Order::whereMonth('tanggal_order', now()->subMonth()->month)
            ->whereYear('tanggal_order', now()->subMonth()->year)
            ->where('status_order', '!=', 'cancelled')
            ->sum('total_harga');

        $monthlyTrend = $lastMonthRevenue > 0 ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;
        $monthlyTrendIcon = $monthlyTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $monthlyTrendColor = $monthlyTrend >= 0 ? 'success' : 'danger';

        // Completion rate
        $completedOrders = $deliveredOrders;
        $completionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // Active customers (who made orders this month)
        $activeCustomers = Order::whereMonth('tanggal_order', now()->month)
            ->whereYear('tanggal_order', now()->year)
            ->distinct('customer_id')
            ->count('customer_id');

        return [
            Stat::make('Total Orders', Number::format($totalOrders))
                ->description($todayOrders . ' orders today')
                ->descriptionIcon($ordersTrendIcon)
                ->color($ordersTrendColor)
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Total Revenue', 'Rp ' . Number::format($totalRevenue))
                ->description(abs($revenueTrend) < 0.1 ? 'No change vs yesterday' : 
                    ($revenueTrend >= 0 ? '+' : '') . number_format($revenueTrend, 1) . '% vs yesterday')
                ->descriptionIcon($revenueTrendIcon)
                ->color($revenueTrendColor)
                ->chart([3, 5, 4, 6, 7, 8, 6, 9]),

            Stat::make('Pending Orders', Number::format($pendingOrders))
                ->description('Requires attention')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 20 ? 'danger' : ($pendingOrders > 10 ? 'warning' : 'success'))
                ->chart([2, 4, 3, 5, 6, 4, 7, 5]),

            Stat::make('Average Order Value', 'Rp ' . Number::format($averageOrderValue))
                ->description('Per order value')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info')
                ->chart([4, 3, 5, 6, 4, 7, 5, 6]),

            Stat::make('Completion Rate', number_format($completionRate, 1) . '%')
                ->description($completedOrders . ' of ' . $totalOrders . ' orders delivered')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($completionRate >= 80 ? 'success' : ($completionRate >= 60 ? 'warning' : 'danger'))
                ->chart([5, 7, 6, 8, 9, 7, 8, 9]),

            Stat::make('Monthly Revenue', 'Rp ' . Number::format($thisMonthRevenue))
                ->description(abs($monthlyTrend) < 0.1 ? 'Same as last month' : 
                    ($monthlyTrend >= 0 ? '+' : '') . number_format($monthlyTrend, 1) . '% vs last month')
                ->descriptionIcon($monthlyTrendIcon)
                ->color($monthlyTrendColor)
                ->chart([6, 4, 7, 5, 8, 6, 9, 7]),

            Stat::make('Processing Orders', Number::format($processingOrders))
                ->description('In progress')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('warning')
                ->chart([3, 4, 2, 5, 6, 4, 7, 5]),

            Stat::make('Active Customers', Number::format($activeCustomers))
                ->description('Made orders this month')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([8, 6, 9, 7, 10, 8, 11, 9]),

            Stat::make('Today\'s Revenue', 'Rp ' . Number::format($todayRevenue))
                ->description($yesterdayRevenue > 0 ? 
                    (abs($revenueTrend) < 0.1 ? 'Same as yesterday' : 
                        ($revenueTrend >= 0 ? '+' : '') . number_format($revenueTrend, 1) . '% vs yesterday') :
                    'First revenue today')
                ->descriptionIcon($revenueTrendIcon)
                ->color($revenueTrendColor)
                ->chart([5, 3, 7, 4, 8, 6, 9, 7]),
        ];
    }

    protected function getColumns(): int
    {
        return 3; // 3 columns layout
    }

    /**
     * Get additional statistics for dashboard
     */
    public static function getAdditionalStats(): array
    {
        return [
            'status_breakdown' => [
                'pending' => Order::where('status_order', 'pending')->count(),
                'processing' => Order::where('status_order', 'processing')->count(),
                'shipped' => Order::where('status_order', 'shipped')->count(),
                'delivered' => Order::where('status_order', 'delivered')->count(),
                'cancelled' => Order::where('status_order', 'cancelled')->count(),
            ],
            'revenue_breakdown' => [
                'today' => Order::whereDate('tanggal_order', today())->where('status_order', '!=', 'cancelled')->sum('total_harga'),
                'this_week' => Order::whereBetween('tanggal_order', [now()->startOfWeek(), now()->endOfWeek()])->where('status_order', '!=', 'cancelled')->sum('total_harga'),
                'this_month' => Order::whereMonth('tanggal_order', now()->month)->whereYear('tanggal_order', now()->year)->where('status_order', '!=', 'cancelled')->sum('total_harga'),
                'this_year' => Order::whereYear('tanggal_order', now()->year)->where('status_order', '!=', 'cancelled')->sum('total_harga'),
            ],
            'top_customers' => Customer::withCount(['orders' => function ($query) {
                $query->where('status_order', '!=', 'cancelled');
            }])
            ->orderByDesc('orders_count')
            ->limit(5)
            ->get(),
            'expired_orders' => Order::where('expired_at', '<', now())->where('status_order', 'pending')->count(),
            'high_value_orders' => Order::where('total_harga', '>', 5000000)->where('status_order', '!=', 'cancelled')->count(),
        ];
    }
}