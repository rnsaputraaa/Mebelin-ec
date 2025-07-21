<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Wishlist;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\WishlistResource\Pages;

class WishlistResource extends Resource
{
    protected static ?string $model = Wishlist::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?string $navigationLabel = 'Wishlists';

    protected static ?string $modelLabel = 'Wishlist';

    protected static ?string $pluralModelLabel = 'Wishlists';

    protected static ?int $navigationSort = 4;

    // Disable create dan edit - hanya read only
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Form tidak digunakan karena read-only
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('product.main_image.url_gambar')
                    ->label('Product Image')
                    ->height(60)
                    ->width(60)
                    ->square()
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->defaultImageUrl('https://via.placeholder.com/100x100/e5e7eb/9ca3af?text=No+Image')
                    ->getStateUsing(function ($record) {
                        $mainImage = $record->product?->images()?->where('first_picture', true)->first();
                        return $mainImage ? asset('storage/' . $mainImage->url_gambar) : null;
                    }),

                TextColumn::make('customer.nama_lengkap')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->limit(20)
                    ->weight('medium')
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 20 ? $state : null;
                    }),

                TextColumn::make('customer.user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->color('info')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->tooltip('Click to copy'),

                TextColumn::make('product.product_name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->weight('medium')
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                TextColumn::make('product.category.category_name')
                    ->label('Category')
                    ->badge()
                    ->color('secondary')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('product.stok')
                    ->label('Stock Available')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state > 0 ? $state . ' items' : 'Out of Stock')
                    ->sortable(),

                TextColumn::make('product_price')
                    ->label('Product Price')
                    ->getStateUsing(function ($record) {
                        $product = $record->product;
                        if (!$product || !$product->variants()->exists()) {
                            return 'No price set';
                        }
                        
                        $firstVariant = $product->variants()->with('price')->first();
                        if (!$firstVariant || !$firstVariant->price) {
                            return 'No price set';
                        }
                        
                        $finalPrice = $firstVariant->price->price_sale ?? $firstVariant->price->regular_price;
                        return 'Rp ' . number_format($finalPrice, 0, ',', '.');
                    })
                    ->badge()
                    ->color('success'),

                TextColumn::make('customer.no_telepon')
                    ->label('Phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Added to Wishlist')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getRecord()->created_at->format('d M Y H:i:s');
                    }),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('id_customer')
                    ->label('Filter Customer')
                    ->relationship('customer', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('id_product')
                    ->label('Filter Product')
                    ->relationship('product', 'product_name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('product_category')
                    ->label('Filter by Category')
                    ->relationship('product.category', 'category_name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('in_stock')
                    ->label('Products in Stock Only')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereHas('product', fn ($q) => $q->where('stok', '>', 0))),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Added from date'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Added until date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.wishlist-detail', ['record' => $record]))
                    ->modalWidth('2xl')
                    ->label('Detail'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Remove from Wishlist')
                    ->modalDescription('Are you sure you want to remove this item from the customer\'s wishlist?')
                    ->visible(fn () => Auth::check() && Auth::user()->u_type === 'admin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Remove Selected Items from Wishlists')
                        ->modalDescription('Are you sure you want to remove all selected items from customers\' wishlists?')
                        ->visible(fn (): bool => Auth::check() && Auth::user()->u_type === 'admin'),
                ]),
            ])
            ->emptyStateHeading('No Wishlist Items')
            ->emptyStateDescription('No customers have added any products to their wishlist yet.')
            ->emptyStateIcon('heroicon-o-heart')
            ->poll('30s'); // Auto refresh setiap 30 detik
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWishlists::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        
        if ($count > 100) {
            return 'success';
        } elseif ($count > 50) {
            return 'warning';
        }
        
        return 'primary';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'customer.nama_lengkap',
            'customer.user.email',
            'product.product_name',
            'product.category.category_name'
        ];
    }
}