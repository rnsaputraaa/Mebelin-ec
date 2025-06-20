<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating product comments...');

        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No customers or products found. Please run CustomerSeeder and ProductSeeder first.');
            return;
        }

        $sampleComments = [
            'Produk ini sangat bagus dan sesuai dengan ekspektasi saya.',
            'Kualitas materialnya premium, recommended!',
            'Pengiriman cepat dan packaging aman. Produk sesuai gambar.',
            'Harga sebanding dengan kualitas. Sangat puas dengan pembelian ini.',
            'Designnya modern dan cocok untuk rumah minimalis.',
            'Ukurannya pas dan tidak terlalu besar untuk ruangan saya.',
            'Pelayanan customer service sangat baik dan responsif.',
            'Proses assembly mudah dan instruksi jelas.',
            'Material kayu berkualitas dan finishing rapi.',
            'Warna sesuai dengan yang di foto, sangat memuaskan.',
            'Produk tiba dalam kondisi sempurna tanpa cacat.',
            'Sangat sturdy dan kokoh, worth the price.',
            'Desainnya elegant dan membuat ruangan jadi lebih cantik.',
            'Furniture ini benar-benar mengubah tampilan ruang tamu saya.',
            'Kualitas sesuai harga, recommended untuk yang budget terbatas.',
            'Packagingnya sangat aman, tidak ada yang rusak.',
            'Instruksi pemasangan mudah diikuti.',
            'Cocok untuk yang suka style minimalis modern.',
            'Customer service ramah dan membantu proses pemesanan.',
            'Produk original dan bukan KW. Sangat puas!',
            'Dimensi sesuai dengan deskripsi produk.',
            'Finishing cat sangat rapi dan halus.',
            'Harga terjangkau untuk kualitas sebagus ini.',
            'Proses checkout mudah dan payment method lengkap.',
            'Delivery time sesuai estimasi yang dijanjikan.',
            'Produk multifungsi dan space-saving.',
            'Material eco-friendly, good for environment.',
            'Design ergonomis dan nyaman digunakan.',
            'Build quality sangat baik dan detail finishing bagus.',
        ];

        $commentsData = [];
        $createdCount = 0;

        // Create comments for random customers and products
        foreach ($customers->take(10) as $customer) {
            $numberOfComments = rand(1, 4);
            $customerProducts = $products->random($numberOfComments);

            foreach ($customerProducts as $product) {
                $commentsData[] = [
                    'id_customer' => $customer->id_customer,
                    'id_product' => $product->id_product,
                    'comment' => $sampleComments[array_rand($sampleComments)],
                    'created_at' => $this->randomDateInRange(),
                    'updated_at' => Carbon::now(),
                ];

                $createdCount++;
            }
        }

        // Insert comments
        Content::insert($commentsData);

        $this->command->info("✅ Created {$createdCount} product comments");
        $this->showCommentStatistics();
    }

    private function randomDateInRange(): Carbon
    {
        $startDate = Carbon::now()->subMonths(4);
        $endDate = Carbon::now()->subDays(1);
        
        return Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
    }

    private function showCommentStatistics(): void
    {
        $this->command->info("\n💬 Comment Statistics:");
        $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        $totalComments = Content::count();
        $this->command->info("Total Comments: {$totalComments}");
        
        // Comment length stats
        $avgLength = Content::selectRaw('AVG(LENGTH(comment)) as avg_length')->first()->avg_length;
        if ($avgLength) {
            $this->command->info("Average Comment Length: " . round($avgLength) . " characters");
        }
        
        // Recent comments
        $recentComments = Content::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $this->command->info("Recent Comments (7 days): {$recentComments}");
        
        // Comments per customer
        $customersWithComments = Content::distinct('id_customer')->count();
        $totalCustomers = \App\Models\Customer::count();
        $this->command->info("Customers with Comments: {$customersWithComments}/{$totalCustomers}");
    }
}