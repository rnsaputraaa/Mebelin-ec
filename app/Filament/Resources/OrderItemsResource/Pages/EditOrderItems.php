<?php

namespace App\Filament\Resources\OrderItemsResource\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Filament\Resources\OrderItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class EditOrderItems extends EditRecord
{
    protected static string $resource = OrderItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->color('info'),
                
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Order Item')
                ->modalDescription('Apakah Anda yakin ingin menghapus item order ini? Stok produk akan dikembalikan dan total order akan diupdate.')
                ->after(function () {
                    // Kembalikan stok setelah delete
                    $this->restoreProductStock();
                    // Update total order
                    $this->updateOrderTotal($this->record->id_order);
                }),

            Actions\Action::make('duplicate')
                ->label('Duplikat Item')
                ->icon('heroicon-o-document-duplicate')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Duplikat Order Item')
                ->modalDescription('Apakah Anda ingin membuat duplikat dari item order ini?')
                ->action(function () {
                    $originalData = $this->record->toArray();
                    unset($originalData['id_order_items'], $originalData['created_at'], $originalData['updated_at']);
                    
                    // Check stok sebelum duplikat
                    $product = Product::find($originalData['id_product']);
                    if ($product && $originalData['total'] > $product->stok) {
                        Notification::make()
                            ->title('Stok Tidak Mencukupi!')
                            ->body("Tidak dapat menduplikat item. Stok produk {$product->product_name} hanya tersedia {$product->stok} unit.")
                            ->danger()
                            ->send();
                        return;
                    }
                    
                    $newOrderItem = OrderItem::create($originalData);
                    
                    // Update stok dan total order
                    $this->updateProductStock($originalData['id_product'], $originalData['total'], 'subtract');
                    $this->updateOrderTotal($originalData['id_order']);
                    
                    Notification::make()
                        ->title('Item Berhasil Diduplikat!')
                        ->body('Order item baru telah dibuat berdasarkan item ini.')
                        ->success()
                        ->send();
                        
                    return redirect($this->getResource()::getUrl('edit', ['record' => $newOrderItem]));
                }),
        ];
    }

    /**
     * Mutasi data sebelum mengisi form (untuk edit)
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load additional data untuk form
        $orderItem = $this->record;
        
        if ($orderItem->order) {
            $data['customer_name'] = $orderItem->order->customer->nama_lengkap ?? '';
            $data['order_status'] = $orderItem->order->status_order;
        }
        
        if ($orderItem->product) {
            $data['product_stock'] = $orderItem->product->stok;
            $data['product_category'] = $orderItem->product->category->category_name ?? '';
        }

        return $data;
    }

    /**
     * Mutasi data sebelum update
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $originalQuantity = $this->record->total;
        $newQuantity = $data['total'];
        $productId = $data['id_product'];

        // Jika quantity berubah, validasi stok
        if ($newQuantity != $originalQuantity) {
            $product = Product::find($productId);
            $quantityDifference = $newQuantity - $originalQuantity;
            
            // Jika quantity bertambah, check apakah stok mencukupi
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

        // Auto-calculate subtotal jika tidak ada
        if (empty($data['subtotal'])) {
            $data['subtotal'] = $data['unit_price'] * $data['total'];
        }

        return $data;
    }

    /**
     * Handle update order item dengan stok management
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $originalQuantity = $record->total;
        $originalProductId = $record->id_product;
        $newQuantity = $data['total'];
        $newProductId = $data['id_product'];

        // Update record
        $record->update($data);

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

        // Update order total
        $this->updateOrderTotal($record->id_order);

        return $record;
    }

    /**
     * Update stok produk
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
     * Kembalikan stok produk saat item dihapus
     */
    private function restoreProductStock(): void
    {
        $product = Product::find($this->record->id_product);
        if ($product) {
            $newStock = $product->stok + $this->record->total;
            $newStockSales = $product->stok_sales - $this->record->total;
            
            $product->update([
                'stok' => $newStock,
                'stok_sales' => max(0, $newStockSales),
            ]);
        }
    }

    /**
     * Update total harga order
     */
    private function updateOrderTotal(int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $totalHarga = OrderItem::where('id_order', $orderId)->sum('subtotal');
            $order->update(['total_harga' => $totalHarga]);
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
        return 'Order item berhasil diupdate!';
    }

    /**
     * Actions setelah record diupdate
     */
    protected function afterSave(): void
    {
        $orderItem = $this->record->fresh();
        $order = $orderItem->order;
        $product = $orderItem->product;
        
        Notification::make()
            ->title('Order Item Berhasil Diupdate!')
            ->body("Item {$product->product_name} (Qty: {$orderItem->total}) telah diupdate. Total order {$order->order_number}: Rp " . number_format($order->fresh()->total_harga, 0, ',', '.'))
            ->success()
            ->duration(8000)
            ->send();
    }
}