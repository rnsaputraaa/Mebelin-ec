<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Models\Price;
use App\Models\Product;
use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    /**
     * Mutasi data form sebelum disimpan ke database.
     * Generate slug unik jika belum ada atau kosong.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate slug unik dari product_name
        if (empty($data['slug']) && !empty($data['product_name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['product_name']);
        }

        return $data;
    }

    /**
     * Generate slug unik untuk menghindari duplikasi
     */
    private function generateUniqueSlug(string $productName): string
    {
        $baseSlug = Str::slug($productName);
        $slug = $baseSlug;
        $counter = 1;

        // Cek apakah slug sudah ada, jika ya tambahkan angka di belakang
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Siapkan data product (hapus variants dari data)
        $productData = collect($data)->except(['variants'])->toArray();
        
        // 2. Buat product terlebih dahulu
        $product = Product::create($productData);

        // 3. Buat variants dengan prices jika ada
        if (isset($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $variantData) {
                // Buat price terlebih dahulu
                $price = Price::create([
                    'regular_price' => $variantData['regular_price'],
                    'price_sale' => $variantData['price_sale'] ?? null,
                ]);

                // Buat variant dengan relasi ke product dan price yang baru dibuat
                $product->variants()->create([
                    'color' => $variantData['color'],
                    'id_price' => $price->id_price,
                ]);
            }
        }

        return $product;
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
        return 'Produk berhasil dibuat!';
    }
}