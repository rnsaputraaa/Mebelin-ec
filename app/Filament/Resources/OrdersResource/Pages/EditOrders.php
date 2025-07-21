<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Filament\Resources\OrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class EditOrders extends EditRecord
{
    protected static string $resource = OrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->color('info'),
                
            Actions\Action::make('view_items')
                ->label('View Order Items')
                ->icon('heroicon-o-list-bullet')
                ->color('primary')
                ->url(fn (): string => route('filament.admin.resources.order-items.index', ['tableFilters[id_order][values][0]' => $this->record->id_order])),

            Actions\Action::make('add_item')
                ->label('Add Item')
                ->icon('heroicon-o-plus')
                ->color('success')
                ->url(fn (): string => route('filament.admin.resources.order-items.create', ['id_order' => $this->record->id_order]))
                ->visible(fn () => in_array($this->record->status_order, ['pending', 'processing'])),

            Actions\Action::make('change_status')
                ->label('Change Status')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\Select::make('new_status')
                        ->label('Status Baru')
                        ->options([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required()
                        ->default($this->record->status_order),
                    \Filament\Forms\Components\Textarea::make('status_note')
                        ->label('Catatan Perubahan Status')
                        ->rows(3)
                        ->placeholder('Alasan perubahan status...'),
                ])
                ->action(function (array $data) {
                    $oldStatus = $this->record->status_order;
                    $this->record->updateStatus($data['new_status'], $data['status_note']);
                    
                    Notification::make()
                        ->title('Status Berhasil Diubah!')
                        ->body("Status order {$this->record->order_number} berhasil diubah dari {$oldStatus} ke {$data['new_status']}")
                        ->success()
                        ->send();
                }),

            Actions\Action::make('recalculate_total')
                ->label('Recalculate Total')
                ->icon('heroicon-o-calculator')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Recalculate Order Total')
                ->modalDescription('Apakah Anda ingin menghitung ulang total order berdasarkan order items yang ada?')
                ->action(function () {
                    $oldTotal = $this->record->total_harga;
                    $this->record->recalculateTotal();
                    $newTotal = $this->record->fresh()->total_harga;
                    
                    Notification::make()
                        ->title('Total Berhasil Dihitung Ulang!')
                        ->body("Total order diupdate dari Rp " . number_format($oldTotal, 0, ',', '.') . " menjadi Rp " . number_format($newTotal, 0, ',', '.'))
                        ->success()
                        ->send();
                }),

            Actions\Action::make('duplicate')
                ->label('Duplicate Order')
                ->icon('heroicon-o-document-duplicate')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Duplicate Order')
                ->modalDescription('Apakah Anda ingin membuat duplikat dari order ini?')
                ->action(function () {
                    $newOrderData = $this->record->toArray();
                    unset($newOrderData['id_order'], $newOrderData['created_at'], $newOrderData['updated_at']);
                    $newOrderData['order_number'] = Order::generateOrderNumber();
                    $newOrderData['status_order'] = 'pending';
                    $newOrderData['tanggal_order'] = now()->format('Y-m-d');
                    
                    $newOrder = Order::create($newOrderData);
                    
                    // Duplicate order items
                    foreach ($this->record->orderItems as $item) {
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
                        
                    return redirect(static::getResource()::getUrl('edit', ['record' => $newOrder]));
                }),

            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Order')
                ->modalDescription('Apakah Anda yakin ingin menghapus order ini? Semua order items akan ikut terhapus dan stok akan dikembalikan.')
                ->after(function () {
                    // Restore stock for all order items
                    foreach ($this->record->orderItems as $item) {
                        $product = Product::find($item->id_product);
                        if ($product) {
                            $newStock = $product->stok + $item->total;
                            $newStockSales = $product->stok_sales - $item->total;
                            
                            $product->update([
                                'stok' => $newStock,
                                'stok_sales' => max(0, $newStockSales),
                            ]);
                        }
                    }
                }),
        ];
    }

    /**
     * Mutasi data sebelum mengisi form (untuk edit)
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load additional data untuk form
        $order = $this->record;
        
        if ($order->customer) {
            $data['customer_email'] = $order->customer->user->email ?? '';
            $data['customer_phone'] = $order->customer->no_telepon ?? '';
        }

        // Load order items data
        $data['orderItems'] = $order->orderItems->map(function ($item) {
            return [
                'id_order_items' => $item->id_order_items,
                'id_product' => $item->id_product,
                'product_stock' => $item->product->stok ?? 0,
                'total' => $item->total,
                'unit_price' => $item->unit_price,
                'subtotal' => $item->subtotal,
            ];
        })->toArray();

        return $data;
    }

    /**
     * Mutasi data sebelum update
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Validasi order items jika ada perubahan
        if (isset($data['orderItems']) && is_array($data['orderItems'])) {
            foreach ($data['orderItems'] as $index => $item) {
                if (!empty($item['id_product']) && !empty($item['total'])) {
                    $product = Product::find($item['id_product']);
                    
                    // Get original item untuk validasi stok
                    $originalItem = null;
                    if (!empty($item['id_order_items'])) {
                        $originalItem = OrderItem::find($item['id_order_items']);
                    }
                    
                    // Hitung perbedaan quantity
                    $originalQuantity = $originalItem ? $originalItem->total : 0;
                    $quantityDifference = $item['total'] - $originalQuantity;
                    
                    // Validasi stok jika quantity bertambah
                    if ($quantityDifference > 0 && $product && $quantityDifference > $product->stok) {
                        Notification::make()
                            ->title('Stok Tidak Mencukupi!')
                            ->body("Stok produk {$product->product_name} hanya tersedia {$product->stok} unit. Anda mencoba menambah {$quantityDifference} unit.")
                            ->danger()
                            ->persistent()
                            ->send();
                            
                        $this->halt();
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Handle update order dengan order items management
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // 1. Update data order (kecuali orderItems)
        $orderData = collect($data)->except(['orderItems', 'customer_email', 'customer_phone'])->toArray();
        $record->update($orderData);

        // 2. Handle order items update
        if (isset($data['orderItems']) && is_array($data['orderItems'])) {
            $this->updateOrderItems($record, $data['orderItems']);
        }

        // 3. Recalculate total
        $record->recalculateTotal();

        return $record;
    }

    /**
     * Update order items dengan stock management
     */
    private function updateOrderItems(Order $order, array $itemsData): void
    {
        $existingItemIds = [];
        $totalHarga = 0;

        foreach ($itemsData as $itemData) {
            if (empty($itemData['id_product']) || empty($itemData['total'])) {
                continue;
            }

            if (!empty($itemData['id_order_items'])) {
                // Update existing item
                $orderItem = OrderItem::find($itemData['id_order_items']);
                if ($orderItem) {
                    $this->updateExistingOrderItem($orderItem, $itemData);
                    $existingItemIds[] = $orderItem->id_order_items;
                }
            } else {
                // Create new item
                $newItem = $this->createNewOrderItem($order, $itemData);
                if ($newItem) {
                    $existingItemIds[] = $newItem->id_order_items;
                }
            }

            $totalHarga += $itemData['subtotal'];
        }

        // Delete items yang tidak ada di form
        $itemsToDelete = $order->orderItems()->whereNotIn('id_order_items', $existingItemIds)->get();
        foreach ($itemsToDelete as $item) {
            $this->restoreStockForDeletedItem($item);
            $item->delete();
        }
    }

    /**
     * Update existing order item
     */
    private function updateExistingOrderItem(OrderItem $orderItem, array $itemData): void
    {
        $originalQuantity = $orderItem->total;
        $originalProductId = $orderItem->id_product;
        $newQuantity = $itemData['total'];
        $newProductId = $itemData['id_product'];

        // Update order item
        $orderItem->update([
            'id_product' => $newProductId,
            'total' => $newQuantity,
            'unit_price' => $itemData['unit_price'],
            'subtotal' => $itemData['subtotal'],
        ]);

        // Handle stock changes
        if ($originalProductId == $newProductId) {
            // Same product, adjust quantity
            $quantityDifference = $newQuantity - $originalQuantity;
            
            if ($quantityDifference != 0) {
                $this->updateProductStock($newProductId, abs($quantityDifference), $quantityDifference > 0 ? 'subtract' : 'add');
            }
        } else {
            // Different product, restore old and deduct new
            $this->updateProductStock($originalProductId, $originalQuantity, 'add');
            $this->updateProductStock($newProductId, $newQuantity, 'subtract');
        }
    }

    /**
     * Create new order item
     */
    private function createNewOrderItem(Order $order, array $itemData): ?OrderItem
    {
        $orderItem = $order->orderItems()->create([
            'id_product' => $itemData['id_product'],
            'total' => $itemData['total'],
            'unit_price' => $itemData['unit_price'],
            'subtotal' => $itemData['subtotal'],
        ]);

        // Update stock
        $this->updateProductStock($itemData['id_product'], $itemData['total'], 'subtract');

        return $orderItem;
    }

    /**
     * Update product stock
     */
    private function updateProductStock(int $productId, int $quantity, string $operation): void
    {
        $product = Product::find($productId);
        if (!$product) return;

        if ($operation === 'subtract') {
            $newStock = $product->stok - $quantity;
            $newStockSales = $product->stok_sales + $quantity;
        } else { // add
            $newStock = $product->stok + $quantity;
            $newStockSales = $product->stok_sales - $quantity;
        }

        $product->update([
            'stok' => max(0, $newStock),
            'stok_sales' => max(0, $newStockSales),
        ]);
    }

    /**
     * Restore stock untuk item yang dihapus
     */
    private function restoreStockForDeletedItem(OrderItem $item): void
    {
        $product = Product::find($item->id_product);
        if ($product) {
            $newStock = $product->stok + $item->total;
            $newStockSales = $product->stok_sales - $item->total;
            
            $product->update([
                'stok' => $newStock,
                'stok_sales' => max(0, $newStockSales),
            ]);
        }
    }

    /**
     * Redirect setelah update
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Notification message
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Order berhasil diupdate!';
    }

    /**
     * Actions setelah record diupdate
     */
    protected function afterSave(): void
    {
        $order = $this->record->fresh();
        $customer = $order->customer;
        $itemsCount = $order->orderItems->count();
        
        Notification::make()
            ->title('Order Berhasil Diupdate!')
            ->body("Order {$order->order_number} untuk customer {$customer->nama_lengkap} telah diupdate dengan {$itemsCount} items. Total: Rp " . number_format($order->total_harga, 0, ',', '.'))
            ->success()
            ->duration(8000)
            ->send();
    }
}