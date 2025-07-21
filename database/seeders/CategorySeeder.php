<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating product categories...');

        $categories = [
            [
                'category_name' => 'Kursi & Sofa',
                'description' => 'Berbagai jenis kursi dan sofa untuk ruang tamu, ruang keluarga, dan ruang kerja. Tersedia dalam berbagai model modern dan klasik.',
                'img' => null,
            ],
            [
                'category_name' => 'Meja & Meja Makan',
                'description' => 'Koleksi meja untuk berbagai kebutuhan rumah tangga, mulai dari meja makan, meja kerja, hingga meja hias.',
                'img' => null,
            ],
            [
                'category_name' => 'Lemari & Penyimpanan',
                'description' => 'Solusi penyimpanan rumah tangga dengan berbagai ukuran dan model. Lemari pakaian, lemari dapur, dan rak serbaguna.',
                'img' => null,
            ],
            [
                'category_name' => 'Kasur & Tempat Tidur',
                'description' => 'Tempat tidur berkualitas dengan berbagai ukuran dan model. Dilengkapi kasur nyaman untuk tidur yang berkualitas.',
                'img' => null,
            ],
            [
                'category_name' => 'Dekorasi Rumah',
                'description' => 'Aksesoris dan dekorasi untuk mempercantik rumah Anda. Vas bunga, pigura, lampu hias, dan berbagai ornamen.',
                'img' => null,
            ],
            [
                'category_name' => 'Furniture Outdoor',
                'description' => 'Furniture khusus untuk area luar ruangan seperti taman, teras, dan balkon. Tahan cuaca dan stylish.',
                'img' => null,
            ],
            [
                'category_name' => 'Furniture Kantor',
                'description' => 'Furniture profesional untuk ruang kerja dan kantor. Meja kerja, kursi kantor, lemari filing, dan aksesoris kantor.',
                'img' => null,
            ],
            [
                'category_name' => 'Furniture Anak',
                'description' => 'Furniture khusus untuk kamar anak dengan desain yang aman, colorful, dan menyenangkan. Tempat tidur, meja belajar, dan mainan.',
                'img' => null,
            ],
            [
                'category_name' => 'Rak & Shelving',
                'description' => 'Berbagai jenis rak untuk keperluan display dan penyimpanan. Rak buku, rak sepatu, rak dapur, dan rak serbaguna.',
                'img' => null,
            ],
            [
                'category_name' => 'Lighting & Lampu',
                'description' => 'Koleksi lampu untuk penerangan dan dekorasi rumah. Lampu gantung, lampu meja, lampu lantai, dan lampu dinding.',
                'img' => null,
            ],
        ];

        $createdCount = 0;

        foreach ($categories as $categoryData) {
            // Generate slug dari category_name
            $slug = Str::slug($categoryData['category_name']);
            
            // Cek apakah kategori sudah ada
            $existingCategory = Category::where('slug', $slug)->first();
            
            if ($existingCategory) {
                $this->command->info("Category '{$categoryData['category_name']}' already exists. Skipping...");
                continue;
            }

            // Buat kategori baru
            Category::create([
                'category_name' => $categoryData['category_name'],
                'slug' => $slug,
                'description' => $categoryData['description'],
                'img' => $categoryData['img'],
            ]);

            $createdCount++;
        }

        $totalCategories = Category::count();
        
        $this->command->info("✅ Created {$createdCount} new categories");
        $this->command->info("📊 Total categories: {$totalCategories}");
        
        // Tampilkan daftar kategori
        $this->command->info("\n📋 Available Categories:");
        $categories = Category::all();
        foreach ($categories as $index => $category) {
            $this->command->line(($index + 1) . ". {$category->category_name} ({$category->slug})");
        }
    }
}