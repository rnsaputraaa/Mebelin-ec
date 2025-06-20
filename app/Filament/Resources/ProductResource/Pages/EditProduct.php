<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Models\Price;
use App\Models\Product;
use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutasi data sebelum update untuk handle slug
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Generate slug unik jika product_name berubah
        if (isset($data['product_name']) && 
            $data['product_name'] !== $this->record->product_name) {
            $data['slug'] = Product::generateUniqueSlug(
                $data['product_name'], 
                $this->record->id_product
            );
        }

        return $data;
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load variants dengan price data
        $product = $this->record;
        $variants = $product->variants()->with('price')->get();
        
        $data['variants'] = $variants->map(function ($variant) {
            return [
                'id' => $variant->id_product_variant,
                'color' => $variant->color,
                'regular_price' => $variant->price->regular_price ?? 0,
                'price_sale' => $variant->price->price_sale,
            ];
        })->toArray();

        return $data;
    }

    /**
     * Handle update product beserta variants dan prices
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // 1. Update data product (kecuali variants)
        $productData = collect($data)->except(['variants'])->toArray();
        $record->update($productData);

        // 2. Hapus variants lama beserta price-nya
        foreach ($record->variants as $variant) {
            if ($variant->price) {
                $variant->price->delete();
            }
            $variant->delete();
        }

        // 3. Buat variants baru dengan prices
        if (isset($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $variantData) {
                // Buat price baru
                $price = Price::create([
                    'regular_price' => $variantData['regular_price'],
                    'price_sale' => $variantData['price_sale'] ?? null,
                ]);

                // Buat variant baru
                $record->variants()->create([
                    'color' => $variantData['color'],
                    'id_price' => $price->id_price,
                ]);
            }
        }

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
        return 'Produk berhasil diupdate!';
    }
}