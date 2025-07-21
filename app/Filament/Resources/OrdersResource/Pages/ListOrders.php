<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use App\Filament\Resources\OrdersResource;
use App\Filament\Widgets\OrdersStatsWidget;  // ← Import yang benar
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;

class ListOrders extends ListRecords
{
    protected static string $resource = OrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Order Baru')
                ->icon('heroicon-m-plus'),
        ];
    }

    /**
     * Custom query untuk optimasi loading dengan eager loading
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with([
                'customer',
                'customer.user',
                'orderItems',
                'orderItems.product',
            ]);
    }

    /**
     * Get the page title
     */
    public function getTitle(): string|Htmlable
    {
        return 'Orders Management';
    }

    /**
     * Get the page subtitle
     */
    public function getSubheading(): string|Htmlable|null
    {
        return 'Kelola semua order dari customer';
    }

    /**
     * Define tabs untuk filter data
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Orders')
                ->badge(fn () => \App\Models\Order::count()),

            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_order', 'pending'))
                ->badge(fn () => \App\Models\Order::where('status_order', 'pending')->count())
                ->badgeColor('secondary'),

            'processing' => Tab::make('Processing')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_order', 'processing'))
                ->badge(fn () => \App\Models\Order::where('status_order', 'processing')->count())
                ->badgeColor('warning'),

            'shipped' => Tab::make('Shipped')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_order', 'shipped'))
                ->badge(fn () => \App\Models\Order::where('status_order', 'shipped')->count())
                ->badgeColor('info'),

            'delivered' => Tab::make('Delivered')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_order', 'delivered'))
                ->badge(fn () => \App\Models\Order::where('status_order', 'delivered')->count())
                ->badgeColor('success'),

            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_order', 'cancelled'))
                ->badge(fn () => \App\Models\Order::where('status_order', 'cancelled')->count())
                ->badgeColor('danger'),

            'expired' => Tab::make('Expired')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('expired_at', '<', now()))
                ->badge(fn () => \App\Models\Order::where('expired_at', '<', now())->count())
                ->badgeColor('gray'),

            'high_value' => Tab::make('High Value (>5M)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('total_harga', '>', 5000000))
                ->badge(fn () => \App\Models\Order::where('total_harga', '>', 5000000)->count())
                ->badgeColor('purple'),

            'today' => Tab::make('Today')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('tanggal_order', today()))
                ->badge(fn () => \App\Models\Order::whereDate('tanggal_order', today())->count())
                ->badgeColor('primary'),

            'this_week' => Tab::make('This Week')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('tanggal_order', [now()->startOfWeek(), now()->endOfWeek()]))
                ->badge(fn () => \App\Models\Order::whereBetween('tanggal_order', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->badgeColor('lime'),

            'this_month' => Tab::make('This Month')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('tanggal_order', now()->month)->whereYear('tanggal_order', now()->year))
                ->badge(fn () => \App\Models\Order::whereMonth('tanggal_order', now()->month)->whereYear('tanggal_order', now()->year)->count())
                ->badgeColor('emerald'),
        ];
    }

    /**
     * Get statistics untuk header info
     */
    protected function getHeaderWidgets(): array
    {
        return [
            OrdersStatsWidget::class,  // ← Langsung pakai class name
        ];
    }

    /**
     * Custom actions untuk bulk operations
     */
    protected function getTableBulkActions(): array
    {
        return [
            \Filament\Tables\Actions\BulkActionGroup::make([
                \Filament\Tables\Actions\BulkAction::make('export_orders')
                    ->label('Export Orders')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function ($records) {
                        // Implementation for export
                        $this->exportOrders($records);
                    }),

                \Filament\Tables\Actions\BulkAction::make('mark_as_processing')
                    ->label('Mark as Processing')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            $record->updateStatus('processing', 'Bulk status update to processing');
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Status Updated!')
                            ->body(count($records) . ' orders marked as processing')
                            ->success()
                            ->send();
                    }),

                \Filament\Tables\Actions\BulkAction::make('mark_as_shipped')
                    ->label('Mark as Shipped')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            $record->updateStatus('shipped', 'Bulk status update to shipped');
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Status Updated!')
                            ->body(count($records) . ' orders marked as shipped')
                            ->success()
                            ->send();
                    }),

                \Filament\Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Orders Terpilih')
                    ->modalDescription('Apakah Anda yakin ingin menghapus semua orders yang dipilih? Stok akan dikembalikan.')
                    ->visible(fn (): bool => \Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->u_type === 'admin'),
            ]),
        ];
    }

    /**
     * Export orders functionality
     */
    private function exportOrders($records): void
    {
        // Simple CSV export implementation
        $filename = 'orders_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'Order Number',
                'Customer Name',
                'Customer Email',
                'Status',
                'Total Items',
                'Total Amount',
                'Order Date',
                'Created At',
            ]);

            // Data
            foreach ($records as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer->nama_lengkap,
                    $order->customer->user->email,
                    $order->status_order,
                    $order->orderItems->count(),
                    $order->total_harga,
                    $order->tanggal_order->format('Y-m-d'),
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        \Filament\Notifications\Notification::make()
            ->title('Export Started!')
            ->body('Orders export has been initiated')
            ->success()
            ->send();

        // The response is not returned because the method expects void.
        response()->stream($callback, 200, $headers);
    }

    /**
     * Get summary statistics
     */
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
}