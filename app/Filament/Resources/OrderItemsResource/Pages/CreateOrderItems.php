<?php

namespace App\Filament\Resources\OrderItemsResource\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Filament\Resources\OrderItemsResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateOrderItems extends CreateRecord
{
    protected static string $resource = OrderItemsResource::class;

    /**
     * Mutasi data form sebelum disimpan
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validasi stok produk
        $product = Product::find($data['id_product']);
        if ($product && $data['total'] > $product->stok) {
            Notification::make()
                ->title('Stok Tidak Mencukupi!')
                ->body("Stok produk {$product->product_name} hanya tersedia {$product->stok} unit, tetapi Anda mencoba menambahkan {$data['total']} unit.")
                ->danger()
                ->persistent()
                ->send();
                
            $this->halt();
        }

        // Auto-calculate subtotal jika tidak ada
        if (empty($data['subtotal'])) {
            $data['subtotal'] = $data['unit_price'] * $data['total'];
        }

        return $data;
    }

    /**
     * Handle pembuatan order item dan update stok
     */
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Buat order item
        $orderItem = OrderItem::create($data);

        // 2. Update stok produk (kurangi stok)
        $product = Product::find($data['id_product']);
        if ($product) {
            $newStock = $product->stok - $data['total'];
            $newStockSales = $product->stok_sales + $data['total'];
            
            $product->update([
                'stok' => max(0, $newStock),
                'stok_sales' => $newStockSales,
            ]);
        }

        // 3. Update total order
        $this->updateOrderTotal($data['id_order']);

        return $orderItem;
    }

    /**
     * Update total harga order berdasarkan semua order items
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
     * Redirect ke halaman index setelah berhasil
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Notification message
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Order item berhasil ditambahkan!';
    }

    /**
     * Actions setelah record dibuat
     */
    protected function afterCreate(): void
    {
        $orderItem = $this->record;
        $order = $orderItem->order;
        $product = $orderItem->product;
        
        Notification::make()
            ->title('Order Item Berhasil Ditambahkan!')
            ->body("Item {$product->product_name} (Qty: {$orderItem->total}) telah ditambahkan ke order {$order->order_number}. Total order: Rp " . number_format($order->fresh()->total_harga, 0, ',', '.'))
            ->success()
            ->duration(8000)
            ->send();
    }
}