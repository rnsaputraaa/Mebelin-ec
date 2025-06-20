<?php

namespace App\Filament\Resources\ProductImageResource\Pages;

use App\Models\ProductImage;
use App\Filament\Resources\ProductImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditProductImage extends EditRecord
{
    protected static string $resource = ProductImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function () {
                    // Hapus file dari storage setelah record dihapus
                    if ($this->record->url_gambar && Storage::disk('public')->exists($this->record->url_gambar)) {
                        Storage::disk('public')->delete($this->record->url_gambar);
                    }
                }),
        ];
    }

    /**
     * Handle update image dengan logic main image
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Jika ini diset sebagai gambar utama, unset yang lain untuk produk yang sama
        if (isset($data['first_picture']) && $data['first_picture']) {
            ProductImage::where('product_id', $data['product_id'])
                ->where('id_product_images', '!=', $record->id_product_images)
                ->update(['first_picture' => false]);
        }

        // Jika gambar utama di-unset, pastikan ada gambar lain yang jadi utama
        if (isset($data['first_picture']) && !$data['first_picture']) {
            $hasMainImage = ProductImage::where('product_id', $data['product_id'])
                ->where('id_product_images', '!=', $record->id_product_images)
                ->where('first_picture', true)
                ->exists();
            
            // Jika tidak ada gambar utama lain, set gambar dengan sort terkecil sebagai utama
            if (!$hasMainImage) {
                $firstImage = ProductImage::where('product_id', $data['product_id'])
                    ->where('id_product_images', '!=', $record->id_product_images)
                    ->orderBy('sort')
                    ->first();
                
                if ($firstImage) {
                    $firstImage->update(['first_picture' => true]);
                }
            }
        }

        // Hapus file lama jika gambar diganti
        if (isset($data['url_gambar']) && $data['url_gambar'] !== $record->url_gambar) {
            if ($record->url_gambar && Storage::disk('public')->exists($record->url_gambar)) {
                Storage::disk('public')->delete($record->url_gambar);
            }
        }

        $record->update($data);
        return $record;
    }

    /**
     * Redirect setelah update
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Notification message
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Gambar produk berhasil diupdate!';
    }
}