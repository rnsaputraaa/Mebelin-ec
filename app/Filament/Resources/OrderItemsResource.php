<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\OrderItemsResource\Pages;
use Illuminate\Support\Facades\Auth;

class OrderItemsResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Order Management';

    protected static ?string $navigationLabel = 'Order Items';

    protected static ?string $modelLabel = 'Order Item';

    protected static ?string $pluralModelLabel = 'Order Items';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Order Information')
                ->description('Pilih order yang akan ditambahkan item-nya')
                ->schema([
                    Select::make('id_order')
                        ->label('Order')
                        ->relationship('order', 'order_number')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Pilih order...')
                        ->getSearchResultsUsing(function (string $search) {
                            return Order::where('order_number', 'like', "%{$search}%")
                                ->orWhereHas('customer', function ($query) use ($search) {
                                    $query->where('nama_lengkap', 'like', "%{$search}%");
                                })
                                ->limit(50)
                                ->pluck('order_number', 'id_order');
                        })
                        ->getOptionLabelUsing(function ($value) {
                            $order = Order::find($value);
                            return $order ? $order->order_number . ' - ' . $order->customer->nama_lengkap : '';
                        })
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if ($state) {
                                $order = Order::find($state);
                                $set('order_status', $order?->status_order ?? '');
                                $set('customer_name', $order?->customer?->nama_lengkap ?? '');
                            }
                        }),

                    TextInput::make('customer_name')
                        ->label('Customer')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Pilih order untuk melihat customer'),

                    TextInput::make('order_status')
                        ->label('Status Order')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Pilih order untuk melihat status'),
                ])
                ->columns(3),

            Section::make('Product & Quantity')
                ->description('Pilih produk dan tentukan jumlah item')
                ->schema([
                    Select::make('id_product')
                        ->label('Produk')
                        ->relationship('product', 'product_name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Pilih produk...')
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if ($state) {
                                $product = Product::find($state);
                                $set('product_stock', $product?->stok ?? 0);
                                $set('product_category', $product?->category?->category_name ?? '');
                                
                                // Get lowest price from variants for default unit price
                                $lowestPrice = $product?->variants()
                                    ->join('prices', 'product_variants.id_price', '=', 'prices.id_price')
                                    ->min('prices.regular_price') ?? 0;
                                $set('unit_price', $lowestPrice);
                                
                                // Auto calculate subtotal
                                $quantity = request()->input('total') ?? 1;
                                $set('subtotal', $lowestPrice * $quantity);
                            }
                        }),

                    TextInput::make('product_stock')
                        ->label('Stok Tersedia')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Pilih produk untuk melihat stok'),

                    TextInput::make('product_category')
                        ->label('Kategori Produk')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Pilih produk untuk melihat kategori'),
                ])
                ->columns(3),

            Section::make('Pricing & Calculation')
                ->description('Tentukan harga dan jumlah item')
                ->schema([
                    TextInput::make('total')
                        ->label('Jumlah Item')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->default(1)
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, callable $get, $state) {
                            $unitPrice = $get('unit_price') ?? 0;
                            $subtotal = $unitPrice * ($state ?? 1);
                            $set('subtotal', $subtotal);
                        }),

                    TextInput::make('unit_price')
                        ->label('Harga Satuan')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->step(0.01)
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, callable $get, $state) {
                            $quantity = $get('total') ?? 1;
                            $subtotal = ($state ?? 0) * $quantity;
                            $set('subtotal', $subtotal);
                        }),

                    TextInput::make('subtotal')
                        ->label('Subtotal')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->step(0.01)
                        ->disabled()
                        ->dehydrated(),
                ])
                ->columns(3),

            Section::make('Additional Information')
                ->description('Informasi tambahan (opsional)')
                ->schema([
                    Textarea::make('notes')
                        ->label('Catatan Item')
                        ->rows(3)
                        ->maxLength(500)
                        ->placeholder('Catatan khusus untuk item ini (opsional)')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Order number copied!')
                    ->weight('medium')
                    ->color('primary'),

                TextColumn::make('order.customer.nama_lengkap')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 25 ? $state : null;
                    }),

                TextColumn::make('product.product_name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->weight('medium')
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                TextColumn::make('product.category.category_name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('total')
                    ->label('Qty')
                    ->badge()
                    ->color('secondary')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->alignRight(),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->alignRight(),

                BadgeColumn::make('order.status_order')
                    ->label('Order Status')
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'processing',
                        'info' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'heroicon-s-clock' => 'pending',
                        'heroicon-s-cog-6-tooth' => 'processing',
                        'heroicon-s-truck' => 'shipped',
                        'heroicon-s-check-badge' => 'delivered',
                        'heroicon-s-x-circle' => 'cancelled',
                    ]),

                TextColumn::make('order.tanggal_order')
                    ->label('Order Date')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('id_order')
                    ->label('Filter Order')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('id_product')
                    ->label('Filter Produk')
                    ->relationship('product', 'product_name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('order.status_order')
                    ->label('Filter Status Order')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('subtotal_range')
                    ->form([
                        Forms\Components\TextInput::make('subtotal_from')
                            ->label('Subtotal dari')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('subtotal_until')
                            ->label('Subtotal sampai')
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['subtotal_from'], fn (Builder $query, $amount): Builder => $query->where('subtotal', '>=', $amount))
                            ->when($data['subtotal_until'], fn (Builder $query, $amount): Builder => $query->where('subtotal', '<=', $amount));
                    }),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dibuat dari tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Dibuat sampai tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.modals.order-item-detail', ['record' => $record]))
                    ->modalWidth('3xl')
                    ->label('Detail'),

                Tables\Actions\EditAction::make()
                    ->color('warning'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Order Item')
                    ->modalDescription('Apakah Anda yakin ingin menghapus item order ini? Tindakan ini akan mempengaruhi total order.')
                    ->visible(fn () => static::isAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Order Items Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua order items yang dipilih?')
                        ->visible(fn () => static::isAdmin()),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Order Items')
            ->emptyStateDescription('Belum ada item yang ditambahkan ke order.')
            ->emptyStateIcon('heroicon-o-shopping-cart')
            ->striped()
            ->poll('30s'); // Auto refresh setiap 30 detik
    }

    // Helper method untuk check admin
    protected static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()?->u_type === 'admin';
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
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItems::route('/create'),
            'edit' => Pages\EditOrderItems::route('/{record}/edit'),
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
            'order.order_number',
            'order.customer.nama_lengkap',
            'product.product_name',
        ];
    }
}