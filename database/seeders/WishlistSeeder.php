<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada customers dan products
        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please run CustomerSeeder first.');
            return;
        }

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        $this->command->info('Creating wishlist entries...');

        // Data wishlist yang akan dibuat
        $wishlistData = [];
        $createdEntries = [];

        // 1. Setiap customer memiliki 1-5 wishlist items secara random
        foreach ($customers as $customer) {
            $numberOfItems = rand(1, 5);
            $customerProducts = $products->random($numberOfItems);

            foreach ($customerProducts as $product) {
                // Hindari duplikasi (customer + product yang sama)
                $key = $customer->id_customer . '-' . $product->id_product;
                if (!in_array($key, $createdEntries)) {
                    $wishlistData[] = [
                        'id_customer' => $customer->id_customer,
                        'id_product' => $product->id_product,
                        'created_at' => $this->randomDateInRange(),
                        'updated_at' => Carbon::now(),
                    ];
                    $createdEntries[] = $key;
                }
            }
        }

        // 2. Buat beberapa produk "popular" yang di-wishlist banyak customer
        $popularProducts = $products->random(min(3, $products->count()));
        
        foreach ($popularProducts as $product) {
            // Pilih 3-6 customer random untuk wishlist produk ini
            $randomCustomers = $customers->random(rand(3, min(6, $customers->count())));
            
            foreach ($randomCustomers as $customer) {
                $key = $customer->id_customer . '-' . $product->id_product;
                if (!in_array($key, $createdEntries)) {
                    $wishlistData[] = [
                        'id_customer' => $customer->id_customer,
                        'id_product' => $product->id_product,
                        'created_at' => $this->randomDateInRange(),
                        'updated_at' => Carbon::now(),
                    ];
                    $createdEntries[] = $key;
                }
            }
        }

        // 3. Tambahkan beberapa wishlist yang baru ditambahkan (7 hari terakhir)
        $recentCustomers = $customers->random(min(3, $customers->count()));
        foreach ($recentCustomers as $customer) {
            $recentProducts = $products->random(rand(1, 3));
            
            foreach ($recentProducts as $product) {
                $key = $customer->id_customer . '-' . $product->id_product;
                if (!in_array($key, $createdEntries)) {
                    $wishlistData[] = [
                        'id_customer' => $customer->id_customer,
                        'id_product' => $product->id_product,
                        'created_at' => Carbon::now()->subDays(rand(0, 7)),
                        'updated_at' => Carbon::now(),
                    ];
                    $createdEntries[] = $key;
                }
            }
        }

        // Insert data ke database dalam batch
        $chunks = array_chunk($wishlistData, 50);
        
        foreach ($chunks as $chunk) {
            Wishlist::insert($chunk);
        }

        $totalCreated = count($wishlistData);
        $this->command->info("✅ Created {$totalCreated} wishlist entries successfully!");

        // Tampilkan statistik
        $this->showStatistics();
    }

    /**
     * Generate random date dalam range tertentu
     */
    private function randomDateInRange(): Carbon
    {
        $startDate = Carbon::now()->subMonths(6); // 6 bulan lalu
        $endDate = Carbon::now()->subDays(1);     // Kemarin
        
        $randomTimestamp = rand($startDate->timestamp, $endDate->timestamp);
        
        return Carbon::createFromTimestamp($randomTimestamp);
    }

    /**
     * Tampilkan statistik setelah seeding
     */
    private function showStatistics(): void
    {
        $this->command->info("\n📊 Wishlist Statistics:");
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        // Total wishlist items
        $totalItems = Wishlist::count();
        $this->command->info("Total Wishlist Items: {$totalItems}");
        
        // Customers dengan wishlist
        $customersWithWishlist = Wishlist::distinct('id_customer')->count();
        $totalCustomers = Customer::count();
        $this->command->info("Customers with Wishlist: {$customersWithWishlist}/{$totalCustomers}");
        
        // Products dalam wishlist
        $productsInWishlist = Wishlist::distinct('id_product')->count();
        $totalProducts = Product::count();
        $this->command->info("Products in Wishlist: {$productsInWishlist}/{$totalProducts}");
        
        // Recent items (7 hari terakhir)
        $recentItems = Wishlist::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $this->command->info("Recent Items (7 days): {$recentItems}");
        
        // Popular products (yang di-wishlist 3+ kali)
        $popularProducts = Wishlist::select('id_product')
            ->groupBy('id_product')
            ->havingRaw('COUNT(*) >= 3')
            ->count();
        $this->command->info("Popular Products (3+ wishlists): {$popularProducts}");
        
        // Items per customer (rata-rata)
        if ($customersWithWishlist > 0) {
            $avgItemsPerCustomer = round($totalItems / $customersWithWishlist, 1);
            $this->command->info("Average Items per Customer: {$avgItemsPerCustomer}");
        }
        
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        // Sample data
        $this->command->info("\n🔍 Sample Wishlist Data:");
        $sampleWishlists = Wishlist::with(['customer', 'product'])
            ->latest()
            ->take(5)
            ->get();
            
        foreach ($sampleWishlists as $index => $wishlist) {
            $customerName = $wishlist->customer->nama_lengkap ?? 'Unknown Customer';
            $productName = $wishlist->product->product_name ?? 'Unknown Product';
            $date = $wishlist->created_at->format('d M Y');
            
            $this->command->line(($index + 1) . ". {$customerName} → {$productName} ({$date})");
        }
    }
}