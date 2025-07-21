<?php

namespace App\Filament\Resources\ReportStockResource\Pages;

use App\Filament\Resources\ReportStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListReportStocks extends ListRecords
{
    protected static string $resource = ReportStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Custom query untuk optimasi loading dengan eager loading
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['product']);
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Reports')
                ->badge(fn () => \App\Models\ReportStock::count()),

            'stock_in' => Tab::make('Stock In')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'in'))
                ->badge(fn () => \App\Models\ReportStock::where('type', 'in')->count())
                ->badgeColor('success'),

            'stock_out' => Tab::make('Stock Out')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'out'))
                ->badge(fn () => \App\Models\ReportStock::where('type', 'out')->count())
                ->badgeColor('danger'),

            'today' => Tab::make('Today')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('movement_date', today()))
                ->badge(fn () => \App\Models\ReportStock::whereDate('movement_date', today())->count())
                ->badgeColor('info'),

            'this_week' => Tab::make('This Week')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('movement_date', [now()->startOfWeek(), now()->endOfWeek()]))
                ->badge(fn () => \App\Models\ReportStock::whereBetween('movement_date', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->badgeColor('warning'),

            'adjustments' => Tab::make('Adjustments')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('reference_type', 'adjustment'))
                ->badge(fn () => \App\Models\ReportStock::where('reference_type', 'adjustment')->count())
                ->badgeColor('primary'),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'id_report_stock' => 'ID',
            'product.name' => 'Product',
            'type' => 'Type',
            'quantity' => 'Quantity',
            'movement_date' => 'Date',
            'reference_type' => 'Reference Type',
            'reference_id' => 'Reference ID',
            'notes' => 'Notes',
            'created_by' => 'Created By',
        ];
    }
}