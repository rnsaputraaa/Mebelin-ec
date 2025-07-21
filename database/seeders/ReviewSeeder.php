<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating product reviews...');

        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No customers or products found. Please run CustomerSeeder and ProductSeeder first.');
            return;
        }

        // First, ensure we have some order items
        $this->createOrderItemsIfNeeded($products);

        $reviewsData = [];
        $createdCount = 0;

        // Create reviews for random customers and products
        foreach ($customers->take(12) as $customer) {
            $numberOfReviews = rand(1, 3);
            $customerProducts = $products->random($numberOfReviews);

            foreach ($customerProducts as $product) {
                // Get or create an order item for this product
                $orderItem = OrderItem::where('id_product', $product->id_product)->first();
                
                if (!$orderItem) {
                    // Create a simple order item
                    // Fetch a valid order ID or create a new order if none exists
                    $orderModel = \App\Models\Order::first();
                    if (!$orderModel) {
                        $randomCustomer = Customer::inRandomOrder()->first();
                        $orderModel = \App\Models\Order::create([
                            'customer_id' => $randomCustomer ? $randomCustomer->id_customer : 1,
                            'order_number' => 'ORD' . now()->format('YmdHis') . rand(100,999),
                            'tanggal_order' => now(),
                            'status_order' => 'delivered',
                            'total_harga' => rand(100000, 1500000),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    $defaultOrderId = $orderModel->id_order;
    
                    $orderItem = OrderItem::create([
                        'id_order' => $defaultOrderId,
                        'id_product' => $product->id_product,
                        'total' => rand(1, 2),
                        'unit_price' => rand(100000, 500000),
                        'subtotal' => rand(100000, 1000000),
                    ]);
                }

                $reviewsData[] = [
                    'customer_id' => $customer->id_customer,
                    'product_id' => $product->id_product,
                    'order_item_id' => $orderItem->id_order_items,
                    'rating' => $this->generateRating(),
                    'created_at' => $this->randomDateInRange(),
                    'updated_at' => Carbon::now(),
                ];

                $createdCount++;
            }
        }

        // Insert reviews
        Review::insert($reviewsData);

        $this->command->info("✅ Created {$createdCount} product reviews");
        $this->showReviewStatistics();
    }

    private function createOrderItemsIfNeeded($products)
    {
        $existingCount = OrderItem::count();
        if ($existingCount < 20) {
            $this->command->info('Creating basic order items for reviews...');

            // Fetch a valid order ID or create a new order if none exists
            $orderModel = \App\Models\Order::first();
            if (!$orderModel) {
                $randomCustomer = Customer::inRandomOrder()->first();
                $orderModel = \App\Models\Order::create([
                    'customer_id' => $randomCustomer ? $randomCustomer->id_customer : 1,
                    'order_number' => 'ORD' . now()->format('YmdHis') . rand(100,999),
                    'tanggal_order' => now(),
                    'status_order' => 'delivered',
                    'total_harga' => rand(100000, 1500000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $defaultOrderId = $orderModel->id_order;

            for ($i = $existingCount; $i < 25; $i++) {
                OrderItem::create([
                    'id_order' => $defaultOrderId, // gunakan id_order yang valid, bukan null
                    'id_product' => $products->random()->id_product,
                    'total' => rand(1, 3),
                    'unit_price' => rand(100000, 500000),
                    'subtotal' => rand(100000, 1500000),
                ]);
            }
        }
    }

    private function generateRating(): int
    {
        // Weighted rating distribution (more 4-5 stars)
        $weights = [1 => 5, 2 => 10, 3 => 20, 4 => 35, 5 => 30];
        $total = array_sum($weights);
        $random = rand(1, $total);
        
        $currentWeight = 0;
        foreach ($weights as $rating => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return $rating;
            }
        }
        
        return 5;
    }

    private function randomDateInRange(): Carbon
    {
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now()->subDays(1);
        
        return Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
    }

    private function showReviewStatistics(): void
    {
        $this->command->info("\n⭐ Review Statistics:");
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        $totalReviews = Review::count();
        $this->command->info("Total Reviews: {$totalReviews}");
        
        // Rating distribution
        for ($rating = 1; $rating <= 5; $rating++) {
            $count = Review::where('rating', $rating)->count();
            $stars = str_repeat('⭐', $rating);
            $this->command->line("  {$stars} ({$rating}): {$count} reviews");
        }
        
        // Average rating
        $avgRating = Review::avg('rating');
        if ($avgRating) {
            $this->command->info("Average Rating: " . round($avgRating, 2) . "/5");
        }
    }
}