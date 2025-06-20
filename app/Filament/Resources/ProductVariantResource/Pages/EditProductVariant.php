<?php

namespace App\Filament\Resources\ProductVariantResource\Pages;

use App\Models\Price;
use App\Models\ProductVariant;
use App\Filament\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProductVariant extends EditRecord
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutate data sebelum mengisi form (untuk edit)
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load price data ke form
        $variant = $this->record;
        if ($variant->price) {
            $data['regular_price'] = $variant->price->regular_price;
            $data['price_sale'] = $variant->price->price_sale;
        }

        return $data;
    }

    /**
     * Handle update variant dengan price
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // 1. Update price yang sudah ada
        if ($record->price) {
            $record->price->update([
                'regular_price' => $data['regular_price'],
                'price_sale' => $data['price_sale'] ?? null,
            ]);
        } else {
            // Jika belum ada price, buat baru
            $price = Price::create([
                'regular_price' => $data['regular_price'],
                'price_sale' => $data['price_sale'] ?? null,
            ]);
            
            $data['id_price'] = $price->id_price;
        }

        // 2. Update variant data (kecuali price fields)
        $variantData = collect($data)->except(['regular_price', 'price_sale'])->toArray();
        $record->update($variantData);

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
        return 'Product Variant berhasil diupdate!';
    }
}