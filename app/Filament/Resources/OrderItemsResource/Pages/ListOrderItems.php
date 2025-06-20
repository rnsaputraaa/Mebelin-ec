<?php

namespace App\Filament\Resources\OrderItemsResource\Pages;

use App\Filament\Resources\OrderItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Widgets\OrderItemsStatsWidget; 

class ListOrderItems extends ListRecords
{
    protected static string $resource = OrderItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Order Item')
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
                'order',
                'order.customer',
                'product',
                'product.category',
            ]);
    }

    /**
     * Get the page title
     */
    public function getTitle(): string|Htmlable
    {
        return 'Order Items Management';
    }

    /**
     * Get the page subtitle
     */
    public function getSubheading(): string|Htmlable|null
    {
        return 'Kelola semua item dalam order customer';
    }

    /**
     * Define tabs untuk filter data
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Items')
                ->badge(fn () => \App\Models\OrderItem::count()),

            'pending_orders' => Tab::make('Pending Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('order', fn ($q) => $q->where('status_order', 'pending')))
                ->badge(fn () => \App\Models\OrderItem::whereHas('order', fn ($q) => $q->where('status_order', 'pending'))->count())
                ->badgeColor('secondary'),

            'processing_orders' => Tab::make('Processing Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('order', fn ($q) => $q->where('status_order', 'processing')))
                ->badge(fn () => \App\Models\OrderItem::whereHas('order', fn ($q) => $q->where('status_order', 'processing'))->count())
                ->badgeColor('warning'),

            'shipped_orders' => Tab::make('Shipped Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('order', fn ($q) => $q->where('status_order', 'shipped')))
                ->badge(fn () => \App\Models\OrderItem::whereHas('order', fn ($q) => $q->where('status_order', 'shipped'))->count())
                ->badgeColor('info'),

            'delivered_orders' => Tab::make('Delivered Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('order', fn ($q) => $q->where('status_order', 'delivered')))
                ->badge(fn () => \App\Models\OrderItem::whereHas('order', fn ($q) => $q->where('status_order', 'delivered'))->count())
                ->badgeColor('success'),

            'high_value' => Tab::make('High Value Items (>1M)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('subtotal', '>', 1000000))
                ->badge(fn () => \App\Models\OrderItem::where('subtotal', '>', 1000000)->count())
                ->badgeColor('danger'),

            'today' => Tab::make('Today')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('created_at', today()))
                ->badge(fn () => \App\Models\OrderItem::whereDate('created_at', today())->count())
                ->badgeColor('primary'),

            'this_week' => Tab::make('This Week')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
                ->badge(fn () => \App\Models\OrderItem::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->badgeColor('gray'),
        ];
    }

    /**
     * Get statistics untuk header
     */
    protected function getHeaderWidgets(): array
    {
        return [
            OrderItemsStatsWidget::class,
        ];
    }
}