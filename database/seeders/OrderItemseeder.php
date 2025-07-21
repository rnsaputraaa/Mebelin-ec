<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating order items...');

        $orders = Order::all();
        $products = Product::with('variants.price')->get();

        if ($orders->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No orders or products found. Please run OrderSeeder and ProductSeeder first.');
            return;
        }

        $createdCount = 0;

        foreach ($orders as $order) {
            $numberOfItems = rand(1, 4); // 1-4 items per order
            $selectedProducts = $products->random($numberOfItems);
            $orderTotal = 0;

            foreach ($selectedProducts as $product) {
                // Get random variant and its price
                if ($product->variants->isEmpty()) {
                    continue;
                }

                $variant = $product->variants->random();
                if (!$variant || !$variant->price) {
                    continue;
                }

                $quantity = rand(1, 3);
                $unitPrice = $variant->price->price_sale ?? $variant->price->regular_price;
                $subtotal = $unitPrice * $quantity;
                $orderTotal += $subtotal;

                // Create order item using Eloquent model
                OrderItem::create([
                    'id_product' => $product->id_product,
                    'total' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                    'created_at' => $order->created_at,
                    'updated_at' => Carbon::now(),
                ]);

                $createdCount++;
            }

            // Update order total
            $order->update(['total_harga' => $orderTotal]);
        }

        $this->command->info("✅ Created {$createdCount} order items");
        $this->showOrderItemStatistics();
    }

    private function showOrderItemStatistics(): void
    {
        $this->command->info("\n📊 Order Item Statistics:");
        
        $totalItems = OrderItem::count();
        $totalOrders = Order::count();
        $avgItemsPerOrder = $totalOrders > 0 ? round($totalItems / $totalOrders, 1) : 0;
        
        $this->command->line("  Total Order Items: {$totalItems}");
        $this->command->line("  Average Items per Order: {$avgItemsPerOrder}");
        
        // Revenue statistics
        $totalRevenue = Order::sum('total_harga');
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;
        
        $this->command->line("  Total Revenue: Rp " . number_format($totalRevenue));
        $this->command->line("  Average Order Value: Rp " . number_format($avgOrderValue));
    }
}