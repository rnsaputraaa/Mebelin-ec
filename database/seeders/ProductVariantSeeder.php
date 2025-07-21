<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Price;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating product variants...');

        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        // Color options untuk berbagai jenis furniture
        $colorOptions = [
            'furniture' => [
                'Natural Wood', 'Dark Brown', 'Light Brown', 'Black', 'White', 
                'Cream', 'Grey', 'Walnut', 'Mahogany', 'Oak'
            ],
            'fabric' => [
                'Navy Blue', 'Dark Grey', 'Light Grey', 'Beige', 'Brown', 
                'Burgundy', 'Olive Green', 'Charcoal', 'Cream', 'Black'
            ],
            'decorative' => [
                'Gold', 'Silver', 'Bronze', 'Copper', 'Rose Gold', 
                'Matte Black', 'White', 'Clear', 'Blue', 'Green'
            ],
            'kids' => [
                'Pink', 'Blue', 'Yellow', 'Green', 'Red', 
                'Purple', 'Orange', 'Rainbow', 'White', 'Pastel Mix'
            ]
        ];

        $createdCount = 0;

        foreach ($products as $product) {
            // Tentukan jenis warna berdasarkan kategori atau nama produk
            $colorSet = $this->determineColorSet($product, $colorOptions);
            
            // Generate 2-4 variants per produk
            $variantCount = rand(2, 4);
            $selectedColors = collect($colorSet)->random($variantCount);

            foreach ($selectedColors as $color) {
                // Generate harga base berdasarkan kategori dan ukuran
                $basePrice = $this->generateBasePrice($product);
                
                // Beberapa variant ada diskon, beberapa tidak
                $hasDiscount = rand(1, 100) <= 30; // 30% chance discount
                $salePrice = null;
                
                if ($hasDiscount) {
                    $discountPercent = rand(10, 40); // 10-40% discount
                    $salePrice = $basePrice - ($basePrice * $discountPercent / 100);
                }

                // Buat price
                $price = Price::create([
                    'regular_price' => $basePrice,
                    'price_sale' => $salePrice,
                ]);

                // Buat product variant
                ProductVariant::create([
                    'id_product' => $product->id_product,
                    'color' => $color,
                    'id_price' => $price->id_price,
                ]);

                $createdCount++;
            }
        }

        $totalVariants = ProductVariant::count();
        $totalPrices = Price::count();
        
        $this->command->info("✅ Created {$createdCount} new product variants");
        $this->command->info("📊 Total variants: {$totalVariants} | Total prices: {$totalPrices}");
        
        // Statistik pricing
        $this->showPricingStatistics();
    }

    /**
     * Tentukan set warna berdasarkan produk
     */
    private function determineColorSet(Product $product, array $colorOptions): array
    {
        $productName = strtolower($product->product_name);
        $categoryName = strtolower($product->category->category_name ?? '');

        // Furniture anak
        if (str_contains($categoryName, 'anak') || str_contains($productName, 'anak')) {
            return $colorOptions['kids'];
        }
        
        // Dekorasi
        if (str_contains($categoryName, 'dekorasi') || 
            str_contains($productName, 'vas') || 
            str_contains($productName, 'lampu') ||
            str_contains($productName, 'pigura')) {
            return $colorOptions['decorative'];
        }
        
        // Sofa/kursi (fabric)
        if (str_contains($productName, 'sofa') || 
            str_contains($productName, 'kursi') ||
            str_contains($productName, 'kasur')) {
            return $colorOptions['fabric'];
        }

        // Default: furniture colors
        return $colorOptions['furniture'];
    }

    /**
     * Generate base price berdasarkan kategori dan ukuran
     */
    private function generateBasePrice(Product $product): int
    {
        $categoryName = strtolower($product->category->category_name ?? '');
        $size = $product->size ?? 100;
        
        // Base price berdasarkan kategori
        $basePriceMap = [
            'kursi' => 500000,
            'sofa' => 2000000,
            'meja' => 800000,
            'lemari' => 1500000,
            'kasur' => 2500000,
            'tempat tidur' => 1800000,
            'dekorasi' => 150000,
            'outdoor' => 1200000,
            'kantor' => 1000000,
            'anak' => 600000,
            'rak' => 400000,
            'lighting' => 300000,
        ];

        $basePrice = 500000; // Default

        foreach ($basePriceMap as $keyword => $price) {
            if (str_contains($categoryName, $keyword)) {
                $basePrice = $price;
                break;
            }
        }

        // Adjust berdasarkan ukuran
        $sizeMultiplier = 1 + ($size / 200); // Bigger size = higher price
        $adjustedPrice = $basePrice * $sizeMultiplier;

        // Add some randomness (±20%)
        $randomFactor = rand(80, 120) / 100;
        $finalPrice = $adjustedPrice * $randomFactor;

        // Round to nearest 10000
        return round($finalPrice / 10000) * 10000;
    }

    /**
     * Tampilkan statistik pricing
     */
    private function showPricingStatistics(): void
    {
        $this->command->info("\n💰 Pricing Statistics:");
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        // Price ranges
        $prices = Price::all();
        $regularPrices = $prices->pluck('regular_price');
        $salePrices = $prices->whereNotNull('price_sale')->pluck('price_sale');
        
        if ($regularPrices->isNotEmpty()) {
            $this->command->info("Regular Price Range: Rp " . number_format($regularPrices->min()) . " - Rp " . number_format($regularPrices->max()));
            $this->command->info("Average Regular Price: Rp " . number_format($regularPrices->avg()));
        }
        
        if ($salePrices->isNotEmpty()) {
            $this->command->info("Sale Price Range: Rp " . number_format($salePrices->min()) . " - Rp " . number_format($salePrices->max()));
            $this->command->info("Products on Sale: " . $salePrices->count() . "/" . $prices->count());
        }
        
        // Variants per product
        $variantsPerProduct = ProductVariant::selectRaw('id_product, COUNT(*) as variant_count')
            ->groupBy('id_product')
            ->pluck('variant_count');
            
        if ($variantsPerProduct->isNotEmpty()) {
            $this->command->info("Variants per Product: " . $variantsPerProduct->min() . " - " . $variantsPerProduct->max() . " (avg: " . round($variantsPerProduct->avg(), 1) . ")");
        }
    }
}