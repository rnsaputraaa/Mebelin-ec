<?php

namespace App\Filament\Resources\WishlistResource\Pages;

use App\Filament\Resources\WishlistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListWishlists extends ListRecords
{
    protected static string $resource = WishlistResource::class;

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
                'product.category',
                'product.images' => function ($query) {
                    $query->where('first_picture', true);
                },
                'product.variants.price'
            ]);
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Wishlist Items')
                ->badge(fn () => \App\Models\Wishlist::count()),

            'recent' => Tab::make('Recent (7 days)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(7)))
                ->badge(fn () => \App\Models\Wishlist::where('created_at', '>=', now()->subDays(7))->count())
                ->badgeColor('primary'),

            'this_month' => Tab::make('This Month')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
                ->badge(fn () => \App\Models\Wishlist::whereMonth('created_at', now()->month)->count())
                ->badgeColor('success'),

            'in_stock' => Tab::make('In Stock Products')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('product', fn ($q) => $q->where('stok', '>', 0)))
                ->badge(fn () => \App\Models\Wishlist::whereHas('product', fn ($q) => $q->where('stok', '>', 0))->count())
                ->badgeColor('info'),

            'out_of_stock' => Tab::make('Out of Stock')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('product', fn ($q) => $q->where('stok', '<=', 0)))
                ->badge(fn () => \App\Models\Wishlist::whereHas('product', fn ($q) => $q->where('stok', '<=', 0))->count())
                ->badgeColor('danger'),

            'popular_products' => Tab::make('Popular Products')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->select('wishlist.*')
                        ->join('products', 'wishlist.id_product', '=', 'products.id_product')
                        ->whereIn('wishlist.id_product', function ($subQuery) {
                            $subQuery->select('id_product')
                                ->from('wishlist')
                                ->groupBy('id_product')
                                ->havingRaw('COUNT(*) >= 2'); // Products with 2+ wishlist entries
                        })
                        ->orderByRaw('(SELECT COUNT(*) FROM wishlist w2 WHERE w2.id_product = wishlist.id_product) DESC');
                })
                ->badge(function () {
                    return \App\Models\Wishlist::select('id_product')
                        ->groupBy('id_product')
                        ->havingRaw('COUNT(*) >= 2')
                        ->count();
                })
                ->badgeColor('warning'),
        ];
    }
}