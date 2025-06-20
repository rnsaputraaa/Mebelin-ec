<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating products...');

        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $products = [
            // Kursi & Sofa
            [
                'product_name' => 'Sofa Minimalis 3 Dudukan',
                'description' => 'Sofa modern dengan desain minimalis, cocok untuk ruang tamu yang elegan. Bahan berkualitas tinggi dan nyaman untuk diduduki.',
                'stok' => 25,
                'size' => 180,
                'category' => 'kursi-sofa',
            ],
            [
                'product_name' => 'Kursi Kantor Ergonomis',
                'description' => 'Kursi kantor dengan desain ergonomis, dilengkapi dengan penyangga punggung yang dapat disesuaikan dan roda yang mudah bergerak.',
                'stok' => 40,
                'size' => 65,
                'category' => 'kursi-sofa',
            ],
            [
                'product_name' => 'Sofa Bed Multifungsi',
                'description' => 'Sofa yang dapat diubah menjadi tempat tidur, sangat praktis untuk apartemen atau ruang tamu yang terbatas.',
                'stok' => 15,
                'size' => 200,
                'category' => 'kursi-sofa',
            ],
            
            // Meja & Meja Makan
            [
                'product_name' => 'Meja Makan Kayu Jati 6 Kursi',
                'description' => 'Set meja makan dari kayu jati asli dengan 6 kursi matching. Desain klasik yang elegan dan tahan lama.',
                'stok' => 8,
                'size' => 160,
                'category' => 'meja-meja-makan',
            ],
            [
                'product_name' => 'Meja Kerja Modern Steel',
                'description' => 'Meja kerja dengan rangka besi dan top kayu, desain industrial modern. Cocok untuk home office atau workspace.',
                'stok' => 30,
                'size' => 120,
                'category' => 'meja-meja-makan',
            ],
            [
                'product_name' => 'Coffee Table Skandinavia',
                'description' => 'Meja kopi dengan desain Skandinavia yang simple dan fungsional. Warna natural wood yang hangat.',
                'stok' => 22,
                'size' => 90,
                'category' => 'meja-meja-makan',
            ],
            
            // Lemari & Penyimpanan
            [
                'product_name' => 'Lemari Pakaian 4 Pintu',
                'description' => 'Lemari pakaian besar dengan 4 pintu, dilengkapi dengan gantungan baju dan rak sepatu di bagian bawah.',
                'stok' => 12,
                'size' => 200,
                'category' => 'lemari-penyimpanan',
            ],
            [
                'product_name' => 'Lemari Dapur Set Lengkap',
                'description' => 'Set lemari dapur atas dan bawah dengan finishing HPL tahan air. Dilengkapi dengan soft closing system.',
                'stok' => 6,
                'size' => 300,
                'category' => 'lemari-penyimpanan',
            ],
            [
                'product_name' => 'Rak Buku 5 Tingkat',
                'description' => 'Rak buku minimalis dengan 5 tingkat, cocok untuk perpustakaan pribadi atau ruang belajar.',
                'stok' => 35,
                'size' => 180,
                'category' => 'lemari-penyimpanan',
            ],
            
            // Kasur & Tempat Tidur
            [
                'product_name' => 'Tempat Tidur Queen Size',
                'description' => 'Tempat tidur ukuran queen dengan headboard elegant dan storage di bagian bawah. Termasuk kasur spring bed.',
                'stok' => 18,
                'size' => 160,
                'category' => 'kasur-tempat-tidur',
            ],
            [
                'product_name' => 'Kasur Memory Foam King Size',
                'description' => 'Kasur premium dengan teknologi memory foam yang mengikuti bentuk tubuh. Memberikan kenyamanan tidur maksimal.',
                'stok' => 10,
                'size' => 180,
                'category' => 'kasur-tempat-tidur',
            ],
            [
                'product_name' => 'Dipan Kayu Minimalis',
                'description' => 'Dipan kayu dengan desain minimalis tanpa headboard. Cocok untuk kamar dengan konsep simple dan clean.',
                'stok' => 28,
                'size' => 120,
                'category' => 'kasur-tempat-tidur',
            ],
            
            // Dekorasi Rumah
            [
                'product_name' => 'Vas Bunga Keramik Artistic',
                'description' => 'Vas bunga dari keramik dengan desain artistic modern. Tersedia dalam berbagai warna dan motif.',
                'stok' => 50,
                'size' => 30,
                'category' => 'dekorasi-rumah',
            ],
            [
                'product_name' => 'Pigura Foto Vintage Set 6',
                'description' => 'Set 6 pigura foto dengan desain vintage dalam berbagai ukuran. Cocok untuk gallery wall di ruang tamu.',
                'stok' => 45,
                'size' => 25,
                'category' => 'dekorasi-rumah',
            ],
            [
                'product_name' => 'Lampu Hias LED Strip',
                'description' => 'Lampu hias LED strip untuk aksen lighting. Dapat dipasang di berbagai area rumah untuk menciptakan suasana.',
                'stok' => 60,
                'size' => 5,
                'category' => 'dekorasi-rumah',
            ],
            
            // Furniture Outdoor
            [
                'product_name' => 'Set Meja Kursi Taman Rotan',
                'description' => 'Set furniture taman dari bahan rotan sintetis tahan cuaca. 1 meja dan 4 kursi dengan cushion waterproof.',
                'stok' => 12,
                'size' => 120,
                'category' => 'furniture-outdoor',
            ],
            [
                'product_name' => 'Gazebo Kayu Minimalis',
                'description' => 'Gazebo kayu dengan atap genteng metal. Cocok untuk area outdoor sebagai tempat bersantai.',
                'stok' => 5,
                'size' => 300,
                'category' => 'furniture-outdoor',
            ],
            
            // Furniture Kantor
            [
                'product_name' => 'Meja Meeting Executive',
                'description' => 'Meja meeting besar untuk ruang conference dengan finishing veneer kayu. Dilengkapi dengan cable management.',
                'stok' => 8,
                'size' => 240,
                'category' => 'furniture-kantor',
            ],
            [
                'product_name' => 'Kursi Direktur Kulit Asli',
                'description' => 'Kursi direktur premium dengan bahan kulit asli dan rangka kayu mahoni. Symbol prestise untuk ruang kerja.',
                'stok' => 15,
                'size' => 70,
                'category' => 'furniture-kantor',
            ],
            
            // Furniture Anak
            [
                'product_name' => 'Tempat Tidur Anak Karakter',
                'description' => 'Tempat tidur anak dengan desain karakter lucu. Dilengkapi dengan pagar pengaman dan laci penyimpanan.',
                'stok' => 20,
                'size' => 90,
                'category' => 'furniture-anak',
            ],
            [
                'product_name' => 'Meja Belajar Anak Adjustable',
                'description' => 'Meja belajar anak dengan ketinggian yang dapat disesuaikan. Dilengkapi dengan kursi dan lampu belajar.',
                'stok' => 25,
                'size' => 80,
                'category' => 'furniture-anak',
            ],
        ];

        $createdCount = 0;
        $categoryMap = $categories->keyBy('slug');

        foreach ($products as $productData) {
            // Cari kategori berdasarkan slug
            $category = $categoryMap->get($productData['category']);
            
            if (!$category) {
                $this->command->warn("Category '{$productData['category']}' not found. Skipping product '{$productData['product_name']}'");
                continue;
            }

            // Generate slug unik
            $baseSlug = Str::slug($productData['product_name']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // Buat produk
            Product::create([
                'product_name' => $productData['product_name'],
                'slug' => $slug,
                'description' => $productData['description'],
                'stok' => $productData['stok'],
                'stok_sales' => rand(0, $productData['stok'] * 0.3), // 0-30% dari stok sebagai terjual
                'size' => $productData['size'],
                'view' => rand(50, 500), // Random view count
                'id_category' => $category->id_category,
            ]);

            $createdCount++;
        }

        $totalProducts = Product::count();
        
        $this->command->info("✅ Created {$createdCount} new products");
        $this->command->info("📊 Total products: {$totalProducts}");
        
        // Statistik per kategori
        $this->command->info("\n📊 Products per Category:");
        foreach ($categories as $category) {
            $productCount = Product::where('id_category', $category->id_category)->count();
            $this->command->line("  {$category->category_name}: {$productCount} products");
        }
    }
}