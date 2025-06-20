<?php

namespace App\Filament\Resources\ProductImageResource\Pages;

use App\Models\ProductImage;
use App\Filament\Resources\ProductImageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProductImage extends CreateRecord
{
    protected static string $resource = ProductImageResource::class;

    /**
     * Handle pembuatan multiple images dengan logic auto-sort dan main image
     */
    protected function handleRecordCreation(array $data): Model
    {
        $productId = $data['product_id'];
        $images = $data['images'] ?? [];
        $setFirstAsMain = $data['first_picture'] ?? true;
        $startSort = $data['start_sort'] ?? 0;

        // Cek apakah sudah ada gambar untuk produk ini
        $existingImagesCount = ProductImage::where('product_id', $productId)->count();
        $hasMainImage = ProductImage::where('product_id', $productId)->where('first_picture', true)->exists();

        // Jika set gambar pertama sebagai utama dan belum ada gambar utama, unset yang lain
        if ($setFirstAsMain && !$hasMainImage) {
            ProductImage::where('product_id', $productId)->update(['first_picture' => false]);
        }

        // Get existing sort numbers untuk avoid duplicate
        $existingSorts = ProductImage::where('product_id', $productId)
            ->pluck('sort')
            ->toArray();

        $createdImages = [];
        $currentSort = $this->getNextAvailableSort($existingSorts, $startSort);

        foreach ($images as $index => $imagePath) {
            // Skip sort yang sudah ada
            while (in_array($currentSort, $existingSorts)) {
                $currentSort++;
            }

            $imageData = [
                'product_id' => $productId,
                'url_gambar' => $imagePath,
                'first_picture' => ($index === 0 && $setFirstAsMain && !$hasMainImage),
                'sort' => $currentSort,
            ];

            $createdImages[] = ProductImage::create($imageData);
            $existingSorts[] = $currentSort; // Add to existing untuk avoid duplicate di loop ini
            $currentSort++;
        }

        // Return image pertama yang dibuat
        return $createdImages[0] ?? new ProductImage();
    }

    /**
     * Get next available sort number
     */
    private function getNextAvailableSort(array $existingSorts, int $startSort = 0): int
    {
        $sort = $startSort;
        while (in_array($sort, $existingSorts)) {
            $sort++;
        }
        return $sort;
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
        return 'Gambar produk berhasil diupload!';
    }
}