<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // 1. User & Customer Data
        $this->command->info('👥 Seeding Users & Customers...');
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
        ]);

        // 2. Product Management Data
        $this->command->info('📦 Seeding Product Management Data...');
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
            ProductImageSeeder::class,
        ]);

        // 3. Customer Interaction Data
        $this->command->info('💝 Seeding Customer Interaction Data...');
        $this->call([
            WishlistSeeder::class,
            ReviewSeeder::class,
            ContentSeeder::class,
        ]);

        // 4. Order & Transaction Data (Optional - Skip if problematic)
        $this->command->info('🛒 Seeding Order & Transaction Data (Optional)...');
        try {
            $this->call([
                OrderSeeder::class,
                OrderItemSeeder::class,
            ]);
        } catch (\Exception $e) {
            $this->command->warn('⚠️  Skipping Order seeders due to schema issues: ' . $e->getMessage());
            $this->command->info('💡 Orders can be created manually through admin panel');
        }

        // 5. Inventory Management Data
        $this->command->info('📊 Seeding Inventory Management Data...');
        $this->call([
            ReportStockSeeder::class,
        ]);

        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('✅ Database seeding completed successfully!');
        
        // Tampilkan ringkasan data
        $this->showDataSummary();
    }

    /**
     * Tampilkan ringkasan data yang telah di-seed
     */
    private function showDataSummary(): void
    {
        $this->command->info("\n📋 Data Summary:");
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        // Users & Customers
        $userCount = \App\Models\User::count();
        $customerCount = \App\Models\Customer::count();
        $addressCount = \App\Models\CustomerAddress::count();
        $this->command->info("Users: {$userCount} | Customers: {$customerCount} | Addresses: {$addressCount}");
        
        // Products
        $categoryCount = \App\Models\Category::count();
        $productCount = \App\Models\Product::count();
        $variantCount = \App\Models\ProductVariant::count();
        $imageCount = \App\Models\ProductImage::count();
        $this->command->info("Categories: {$categoryCount} | Products: {$productCount} | Variants: {$variantCount} | Images: {$imageCount}");
        
        // Customer Interactions ⭐ FOCUS AREA
        $wishlistCount = \App\Models\Wishlist::count();
        $reviewCount = \App\Models\Review::count();
        $commentCount = \App\Models\Content::count();
        $this->command->info("⭐ Wishlists: {$wishlistCount} | Reviews: {$reviewCount} | Comments: {$commentCount}");
        
        // Orders (may be 0 if skipped)
        $orderCount = \App\Models\Order::count();
        $orderItemCount = \App\Models\OrderItem::count();
        if ($orderCount > 0) {
            $this->command->info("Orders: {$orderCount} | Order Items: {$orderItemCount}");
        } else {
            $this->command->info("Orders: Skipped (create manually in admin)");
        }
        
        // Inventory
        $stockReportCount = \App\Models\ReportStock::count();
        $this->command->info("Stock Reports: {$stockReportCount}");
        
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🚀 Your application is ready with sample data!");
        $this->command->info("📱 Login as admin: admin@gmail.com | password: password");
        $this->command->info("🌐 Access Filament Admin: /admin");
        $this->command->info("⭐ Check WishlistResource: Customer Management > Wishlists");
        
        // Show wishlist statistics
        if ($wishlistCount > 0) {
            $this->showWishlistSummary();
        }
    }

    /**
     * Show wishlist specific summary
     */
    private function showWishlistSummary(): void
    {
        $this->command->info("\n💝 Wishlist Summary:");
        
        // Customers with wishlist
        $customersWithWishlist = \App\Models\Wishlist::distinct('id_customer')->count();
        $totalCustomers = \App\Models\Customer::count();
        
        // Products in wishlist
        $productsInWishlist = \App\Models\Wishlist::distinct('id_product')->count();
        $totalProducts = \App\Models\Product::count();
        
        // Recent wishlist items
        $recentItems = \App\Models\Wishlist::where('created_at', '>=', now()->subDays(7))->count();
        
        $this->command->line("  📊 {$customersWithWishlist}/{$totalCustomers} customers have wishlists");
        $this->command->line("  📦 {$productsInWishlist}/{$totalProducts} products are wishlisted");
        $this->command->line("  🕒 {$recentItems} items added in last 7 days");
        
        // Sample wishlist items
        $sampleWishlists = \App\Models\Wishlist::with(['customer', 'product'])
            ->latest()
            ->take(3)
            ->get();
            
        if ($sampleWishlists->isNotEmpty()) {
            $this->command->info("  📝 Sample wishlist items:");
            foreach ($sampleWishlists as $wishlist) {
                $customerName = $wishlist->customer->nama_lengkap ?? 'Unknown';
                $productName = $wishlist->product->product_name ?? 'Unknown';
                $this->command->line("    • {$customerName} → {$productName}");
            }
        }
    }
}