<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Filament\Resources\OrdersResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateOrders extends CreateRecord
{
    protected static string $resource = OrdersResource::class;

    /**
     * Mutasi data form sebelum disimpan
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate order number jika kosong
        if (empty($data['order_number'])) {
            $data['order_number'] = Order::generateOrderNumber();
        }

        // Set expired_at default jika pending dan tidak ada expired_at
        if ($data['status_order'] === 'pending' && empty($data['expired_at'])) {
            $data['expired_at'] = now()->addDays(7);
        }

        // Validasi order items jika ada
        if (isset($data['orderItems']) && is_array($data['orderItems'])) {
            foreach ($data['orderItems'] as $index => $item) {
                if (!empty($item['id_product']) && !empty($item['total'])) {
                    $product = Product::find($item['id_product']);
                    
                    // Validasi stok
                    if ($product && $item['total'] > $product->stok) {
                        Notification::make()
                            ->title('Stok Tidak Mencukupi!')
                            ->body("Stok produk {$product->product_name} hanya tersedia {$product->stok} unit, tetapi Anda mencoba menambahkan {$item['total']} unit.")
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
     * Handle pembuatan order dengan order items
     */
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Siapkan data order (hapus orderItems dari data)
        $orderData = collect($data)->except(['orderItems', 'customer_email', 'customer_phone'])->toArray();
        
        // 2. Buat order terlebih dahulu
        $order = Order::create($orderData);

        // 3. Buat order items jika ada
        if (isset($data['orderItems']) && is_array($data['orderItems'])) {
            $totalHarga = 0;
            
            foreach ($data['orderItems'] as $itemData) {
                if (!empty($itemData['id_product']) && !empty($itemData['total'])) {
                    // Buat order item
                    $orderItem = $order->orderItems()->create([
                        'id_product' => $itemData['id_product'],
                        'total' => $itemData['total'],
                        'unit_price' => $itemData['unit_price'],
                        'subtotal' => $itemData['subtotal'],
                    ]);

                    $totalHarga += $itemData['subtotal'];

                    // Update stok produk
                    $product = Product::find($itemData['id_product']);
                    if ($product) {
                        $newStock = $product->stok - $itemData['total'];
                        $newStockSales = $product->stok_sales + $itemData['total'];
                        
                        $product->update([
                            'stok' => max(0, $newStock),
                            'stok_sales' => $newStockSales,
                        ]);
                    }
                }
            }

            // Update total harga order
            $order->update(['total_harga' => $totalHarga]);
        }

        return $order;
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
        return 'Order berhasil dibuat!';
    }

    /**
     * Actions setelah record dibuat
     */
    protected function afterCreate(): void
    {
        $order = $this->record->fresh();
        $customer = $order->customer;
        $itemsCount = $order->orderItems->count();
        
        Notification::make()
            ->title('Order Berhasil Dibuat!')
            ->body("Order {$order->order_number} untuk customer {$customer->nama_lengkap} telah dibuat dengan {$itemsCount} items. Total: Rp " . number_format($order->total_harga, 0, ',', '.'))
            ->success()
            ->duration(10000)
            ->send();

        // Log activity atau kirim notifikasi email jika diperlukan
        // $this->sendOrderConfirmationEmail($order);
    }

    /**
     * Custom validation rules
     */
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Buat Order'),
            
            $this->getCreateAnotherFormAction()
                ->label('Buat & Tambah Lagi'),
            
            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }

    /**
     * Custom heading
     */
    public function getHeading(): string
    {
        return 'Buat Order Baru';
    }

    /**
     * Custom subheading
     */
    public function getSubheading(): ?string
    {
        return 'Buat order baru untuk customer dengan item-item yang diperlukan';
    }
}