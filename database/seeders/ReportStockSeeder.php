<?php

namespace Database\Seeders;

use App\Models\ReportStock;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReportStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating stock movement reports...');

        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        $stockReportsData = [];
        $createdCount = 0;

        foreach ($products as $product) {
            // 1. Initial stock (stok awal)
            $initialStock = rand(50, 200);
            $stockReportsData[] = [
                'id_product' => $product->id_product,
                'type' => 'in',
                'quantity' => $initialStock,
                'movement_date' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                'reference_type' => 'initial',
                'reference_id' => null,
                'notes' => 'Stok awal produk',
                'created_by' => 'admin',
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now(),
            ];
            $createdCount++;

            // 2. Purchase stock (pembelian)
            $numberOfPurchases = rand(2, 5);
            for ($i = 0; $i < $numberOfPurchases; $i++) {
                $purchaseDate = Carbon::now()->subDays(rand(1, 90));
                $stockReportsData[] = [
                    'id_product' => $product->id_product,
                    'type' => 'in',
                    'quantity' => rand(10, 100),
                    'movement_date' => $purchaseDate->format('Y-m-d'),
                    'reference_type' => 'purchase',
                    'reference_id' => 'PO-' . $purchaseDate->format('Ymd') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'notes' => $this->getRandomPurchaseNote(),
                    'created_by' => 'admin',
                    'created_at' => $purchaseDate,
                    'updated_at' => Carbon::now(),
                ];
                $createdCount++;
            }

            // 3. Sales stock (penjualan)
            $numberOfSales = rand(3, 8);
            for ($i = 0; $i < $numberOfSales; $i++) {
                $saleDate = Carbon::now()->subDays(rand(1, 60));
                $stockReportsData[] = [
                    'id_product' => $product->id_product,
                    'type' => 'out',
                    'quantity' => rand(1, 10),
                    'movement_date' => $saleDate->format('Y-m-d'),
                    'reference_type' => 'sale',
                    'reference_id' => 'ORD-' . $saleDate->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'notes' => 'Penjualan ke customer',
                    'created_by' => 'admin',
                    'created_at' => $saleDate,
                    'updated_at' => Carbon::now(),
                ];
                $createdCount++;
            }

            // 4. Adjustments (random)
            if (rand(1, 100) <= 30) { // 30% chance adjustment
                $adjustmentDate = Carbon::now()->subDays(rand(1, 30));
                $isPositive = rand(1, 100) <= 70; // 70% positive adjustment
                
                $stockReportsData[] = [
                    'id_product' => $product->id_product,
                    'type' => $isPositive ? 'in' : 'out',
                    'quantity' => rand(1, 20),
                    'movement_date' => $adjustmentDate->format('Y-m-d'),
                    'reference_type' => 'adjustment',
                    'reference_id' => 'ADJ-' . $adjustmentDate->format('Ymd'),
                    'notes' => $this->getRandomAdjustmentNote($isPositive),
                    'created_by' => 'admin',
                    'created_at' => $adjustmentDate,
                    'updated_at' => Carbon::now(),
                ];
                $createdCount++;
            }

            // 5. Returns (jarang)
            if (rand(1, 100) <= 15) { // 15% chance return
                $returnDate = Carbon::now()->subDays(rand(1, 45));
                $stockReportsData[] = [
                    'id_product' => $product->id_product,
                    'type' => 'in',
                    'quantity' => rand(1, 5),
                    'movement_date' => $returnDate->format('Y-m-d'),
                    'reference_type' => 'return',
                    'reference_id' => 'RET-' . $returnDate->format('Ymd'),
                    'notes' => 'Barang return dari customer',
                    'created_by' => 'admin',
                    'created_at' => $returnDate,
                    'updated_at' => Carbon::now(),
                ];
                $createdCount++;
            }

            // 6. Damage (sangat jarang)
            if (rand(1, 100) <= 10) { // 10% chance damage
                $damageDate = Carbon::now()->subDays(rand(1, 60));
                $stockReportsData[] = [
                    'id_product' => $product->id_product,
                    'type' => 'out',
                    'quantity' => rand(1, 3),
                    'movement_date' => $damageDate->format('Y-m-d'),
                    'reference_type' => 'damage',
                    'reference_id' => 'DMG-' . $damageDate->format('Ymd'),
                    'notes' => 'Barang rusak/cacat produksi',
                    'created_by' => 'admin',
                    'created_at' => $damageDate,
                    'updated_at' => Carbon::now(),
                ];
                $createdCount++;
            }
        }

        // Insert stock reports in chunks
        $chunks = array_chunk($stockReportsData, 100);
        foreach ($chunks as $chunk) {
            ReportStock::insert($chunk);
        }

        $this->command->info("✅ Created {$createdCount} stock movement reports");
        $this->showStockStatistics();
    }

    private function getRandomPurchaseNote(): string
    {
        $notes = [
            'Pembelian stock bulanan',
            'Restock barang best seller',
            'Purchase order dari supplier utama',
            'Tambahan stock untuk promo',
            'Stock reguler dari vendor',
            'Pembelian stock seasonal',
            'Reorder stock minimum',
        ];

        return $notes[array_rand($notes)];
    }

    private function getRandomAdjustmentNote(bool $isPositive): string
    {
        if ($isPositive) {
            $notes = [
                'Koreksi stock setelah stock opname',
                'Penambahan stock hasil inventarisasi',
                'Adjustment positif dari audit',
                'Koreksi data stock',
                'Stock yang terlewat pencatatan',
            ];
        } else {
            $notes = [
                'Koreksi stock berlebih',
                'Adjustment negatif hasil audit',
                'Koreksi data stock yang salah',
                'Stock hilang/tidak ditemukan',
                'Penyesuaian setelah stock opname',
            ];
        }

        return $notes[array_rand($notes)];
    }

    private function showStockStatistics(): void
    {
        $this->command->info("\n📊 Stock Movement Statistics:");
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        $totalReports = ReportStock::count();
        $stockIn = ReportStock::where('type', 'in')->count();
        $stockOut = ReportStock::where('type', 'out')->count();
        
        $this->command->info("Total Stock Reports: {$totalReports}");
        $this->command->info("Stock In Reports: {$stockIn}");
        $this->command->info("Stock Out Reports: {$stockOut}");
        
        // By reference type
        $byType = ReportStock::selectRaw('reference_type, COUNT(*) as count')
            ->groupBy('reference_type')
            ->pluck('count', 'reference_type');
            
        $this->command->info("\nBy Reference Type:");
        foreach ($byType as $type => $count) {
            $this->command->line("  {$type}: {$count} reports");
        }
        
        // Total quantities
        $totalIn = ReportStock::where('type', 'in')->sum('quantity');
        $totalOut = ReportStock::where('type', 'out')->sum('quantity');
        $netStock = $totalIn - $totalOut;
        
        $this->command->info("\nQuantity Summary:");
        $this->command->line("  Total Stock In: {$totalIn} units");
        $this->command->line("  Total Stock Out: {$totalOut} units");
        $this->command->line("  Net Stock Movement: {$netStock} units");
        
        // Recent movements
        $recentMovements = ReportStock::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $this->command->info("Recent Movements (7 days): {$recentMovements} reports");
    }
}