<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\OrdersResource\Pages;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class OrdersResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Order Management';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Order Information')
                ->description('Informasi dasar order')
                ->schema([
                    TextInput::make('order_number')
                        ->label('Order Number')
                        ->required()
                        ->unique(Order::class, 'order_number', ignoreRecord: true)
                        ->default(fn () => Order::generateOrderNumber())
                        ->maxLength(255)
                        ->placeholder('ORD20250616001')
                        ->helperText('Order number akan di-generate otomatis jika dikosongkan'),

                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'nama_lengkap')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Pilih customer...')
                        ->getSearchResultsUsing(function (string $search) {
                            return Customer::where('nama_lengkap', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($query) use ($search) {
                                    $query->where('email', 'like', "%{$search}%");
                                })
                                ->limit(50)
                                ->pluck('nama_lengkap', 'id_customer');
                        })
                        ->getOptionLabelUsing(function ($value) {
                            $customer = Customer::find($value);
                            return $customer ? $customer->nama_lengkap . ' (' . $customer->user->email . ')' : '';
                        })
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if ($state) {
                                $customer = Customer::find($state);
                                $set('customer_phone', $customer?->no_telepon ?? '');
                                $set('customer_email', $customer?->user?->email ?? '');
                            }
                        }),

                    TextInput::make('customer_email')
                        ->label('Customer Email')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Pilih customer untuk melihat email'),

                    TextInput::make('customer_phone')
                        ->label('Customer Phone')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Pilih customer untuk melihat no telepon'),
                ])
                ->columns(2),

            Section::make('Order Details')
                ->description('Detail order dan status')
                ->schema([
                    DatePicker::make('tanggal_order')
                        ->label('Tanggal Order')
                        ->required()
                        ->default(now())
                        ->maxDate(now())
                        ->displayFormat('d M Y'),

                    Select::make('status_order')
                        ->label('Status Order')
                        ->options([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped', 
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required()
                        ->default('pending')
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if ($state === 'delivered') {
                                $set('expired_at', null);
                            } elseif ($state === 'pending') {
                                $set('expired_at', now()->addDays(7));
                            }
                        }),

                    DateTimePicker::make('expired_at')
                        ->label('Expired At')
                        ->nullable()
                        ->minDate(now())
                        ->displayFormat('d M Y H:i')
                        ->helperText('Kosongkan jika tidak ada expired date'),

                    TextInput::make('total_harga')
                        ->label('Total Harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->default(0)
                        ->step(0.01)
                        ->disabled()
                        ->dehydrated()
                        ->helperText('Total akan dihitung otomatis dari order items'),
                ])
                ->columns(2),

            Section::make('Order Items')
                ->description('Item-item dalam order ini')
                ->schema([
                    Repeater::make('orderItems')
                        ->label('Daftar Item')
                        ->relationship()
                        ->schema([
                            Select::make('id_product')
                                ->label('Produk')
                                ->relationship('product', 'product_name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if ($state) {
                                        $product = Product::find($state);
                                        $set('product_stock', $product?->stok ?? 0);
                                        
                                        // Get lowest price from variants
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
                                ->dehydrated(false),

                            TextInput::make('total')
                                ->label('Qty')
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
                        ->columns(5)
                        ->createItemButtonLabel('Tambah Item')
                        ->reorderableWithButtons()
                        ->collapsible()
                        ->defaultItems(0)
                        ->live()
                        ->afterStateUpdated(function (callable $set, callable $get) {
                            // Auto calculate total harga
                            $items = $get('orderItems') ?? [];
                            $total = collect($items)->sum('subtotal');
                            $set('total_harga', $total);
                        }),
                ])
                ->collapsible(),

            Section::make('Additional Information')
                ->description('Informasi tambahan')
                ->schema([
                    Textarea::make('catatan')
                        ->label('Catatan Order')
                        ->rows(4)
                        ->maxLength(1000)
                        ->placeholder('Catatan khusus untuk order ini')
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
                TextColumn::make('order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Order number copied!')
                    ->weight('medium')
                    ->color('primary'),

                TextColumn::make('customer.nama_lengkap')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 25 ? $state : null;
                    }),

                TextColumn::make('customer.user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->color('info')
                    ->toggleable(),

                BadgeColumn::make('status_order')
                    ->label('Status')
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

                TextColumn::make('total_items')
                    ->label('Items')
                    ->getStateUsing(function ($record) {
                        return $record->orderItems->count() . ' items';
                    })
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),

                TextColumn::make('total_quantity')
                    ->label('Qty')
                    ->getStateUsing(function ($record) {
                        return $record->orderItems->sum('total');
                    })
                    ->badge()
                    ->color('secondary')
                    ->alignCenter(),

                TextColumn::make('total_harga')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->alignRight(),

                TextColumn::make('tanggal_order')
                    ->label('Order Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('expired_at')
                    ->label('Expires')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->color(fn ($record) => $record->isExpired() ? 'danger' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status_order')
                    ->label('Filter Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple(),

                SelectFilter::make('customer_id')
                    ->label('Filter Customer')
                    ->relationship('customer', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\Filter::make('total_harga_range')
                    ->form([
                        Forms\Components\TextInput::make('total_from')
                            ->label('Total dari')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('total_until')
                            ->label('Total sampai')
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['total_from'], fn (Builder $query, $amount): Builder => $query->where('total_harga', '>=', $amount))
                            ->when($data['total_until'], fn (Builder $query, $amount): Builder => $query->where('total_harga', '<=', $amount));
                    }),

                Tables\Filters\Filter::make('tanggal_order')
                    ->form([
                        Forms\Components\DatePicker::make('order_from')
                            ->label('Order dari tanggal'),
                        Forms\Components\DatePicker::make('order_until')
                            ->label('Order sampai tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['order_from'], fn (Builder $query, $date): Builder => $query->whereDate('tanggal_order', '>=', $date))
                            ->when($data['order_until'], fn (Builder $query, $date): Builder => $query->whereDate('tanggal_order', '<=', $date));
                    }),

                Tables\Filters\Filter::make('expired_orders')
                    ->label('Order Expired')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('expired_at', '<', now())),

                Tables\Filters\Filter::make('high_value_orders')
                    ->label('High Value (>5M)')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('total_harga', '>', 5000000)),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->modalContent(fn ($record) => view('filament.modals.order-detail', ['record' => $record]))
                        ->modalWidth('5xl')
                        ->label('Detail'),

                    EditAction::make()
                        ->color('warning'),

                    Action::make('change_status')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->form([
                            Select::make('new_status')
                                ->label('Status Baru')
                                ->options([
                                    'pending' => 'Pending',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->required(),
                            Textarea::make('status_note')
                                ->label('Catatan Perubahan Status')
                                ->rows(3)
                                ->placeholder('Alasan perubahan status...'),
                        ])
                        ->action(function (Order $record, array $data) {
                            $oldStatus = $record->status_order;
                            $record->updateStatus($data['new_status'], $data['status_note']);
                            
                            Notification::make()
                                ->title('Status Berhasil Diubah!')
                                ->body("Status order {$record->order_number} berhasil diubah dari {$oldStatus} ke {$data['new_status']}")
                                ->success()
                                ->send();
                        }),

                    Action::make('add_items')
                        ->label('Add Items')
                        ->icon('heroicon-o-plus')
                        ->color('success')
                        ->url(fn (Order $record): string => route('filament.admin.resources.order-items.create', ['id_order' => $record->id_order]))
                        ->visible(fn (Order $record) => in_array($record->status_order, ['pending', 'processing'])),

                    Action::make('duplicate')
                        ->label('Duplicate Order')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->modalHeading('Duplicate Order')
                        ->modalDescription('Apakah Anda ingin membuat duplikat dari order ini?')
                        ->action(function (Order $record) {
                            $newOrderData = $record->toArray();
                            unset($newOrderData['id_order'], $newOrderData['created_at'], $newOrderData['updated_at']);
                            $newOrderData['order_number'] = Order::generateOrderNumber();
                            $newOrderData['status_order'] = 'pending';
                            $newOrderData['tanggal_order'] = now()->format('Y-m-d');
                            
                            $newOrder = Order::create($newOrderData);
                            
                            // Duplicate order items
                            foreach ($record->orderItems as $item) {
                                $itemData = $item->toArray();
                                unset($itemData['id_order_items'], $itemData['created_at'], $itemData['updated_at']);
                                $itemData['id_order'] = $newOrder->id_order;
                                
                                $newOrder->orderItems()->create($itemData);
                            }
                            
                            // Recalculate total
                            $newOrder->recalculateTotal();
                            
                            Notification::make()
                                ->title('Order Berhasil Diduplikat!')
                                ->body("Order baru {$newOrder->order_number} telah dibuat berdasarkan order ini.")
                                ->success()
                                ->send();
                                
                            return redirect(static::getUrl('edit', ['record' => $newOrder]));
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Order')
                        ->modalDescription('Apakah Anda yakin ingin menghapus order ini? Semua order items akan ikut terhapus.')
                        ->visible(fn () => static::isAdmin()),
                ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm')
                ->color('gray')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_processing')
                        ->label('Mark as Processing')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->updateStatus('processing', 'Bulk status update to processing');
                            }
                            
                            Notification::make()
                                ->title('Status Updated!')
                                ->body(count($records) . ' orders marked as processing')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('mark_as_shipped')
                        ->label('Mark as Shipped')
                        ->icon('heroicon-o-truck')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->updateStatus('shipped', 'Bulk status update to shipped');
                            }
                            
                            Notification::make()
                                ->title('Status Updated!')
                                ->body(count($records) . ' orders marked as shipped')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Orders Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua orders yang dipilih?')
                        ->visible(fn () => static::isAdmin()),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Orders')
            ->emptyStateDescription('Belum ada order yang dibuat oleh customer.')
            ->emptyStateIcon('heroicon-o-shopping-bag')
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrders::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrders::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_order', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendingCount = static::getModel()::where('status_order', 'pending')->count();
        
        if ($pendingCount > 20) {
            return 'danger';
        } elseif ($pendingCount > 10) {
            return 'warning';
        } elseif ($pendingCount > 0) {
            return 'primary';
        }
        
        return 'success';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'order_number',
            'customer.nama_lengkap',
            'customer.user.email',
            'catatan',
        ];
    }
}