<?php

namespace App\Filament\Resources\ContentResource\Pages;

use App\Filament\Resources\ContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContents extends ListRecords
{
    protected static string $resource = ContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada action create karena read-only
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
                'product',
            ]);
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Comments')
                ->badge(fn () => \App\Models\Content::count()),

            'recent' => Tab::make('Recent (7 days)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(7)))
                ->badge(fn () => \App\Models\Content::where('created_at', '>=', now()->subDays(7))->count())
                ->badgeColor('primary'),

            'this_month' => Tab::make('This Month')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
                ->badge(fn () => \App\Models\Content::whereMonth('created_at', now()->month)->count())
                ->badgeColor('success'),

            'long_comments' => Tab::make('Long Comments')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereRaw('LENGTH(comment) > 100'))
                ->badge(fn () => \App\Models\Content::whereRaw('LENGTH(comment) > 100')->count())
                ->badgeColor('warning'),
        ];
    }
}