<?php

namespace App\Filament\Resources\ProductVariantResource\Pages;

use App\Models\Price;
use App\Models\ProductVariant;
use App\Filament\Resources\ProductVariantResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProductVariant extends CreateRecord
{
    protected static string $resource = ProductVariantResource::class;

    /**
     * Handle pembuatan variant dengan price
     */
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Buat price terlebih dahulu
        $price = Price::create([
            'regular_price' => $data['regular_price'],
            'price_sale' => $data['price_sale'] ?? null,
        ]);

        // 2. Buat product variant dengan price yang baru dibuat
        $variant = ProductVariant::create([
            'id_product' => $data['id_product'],
            'color' => $data['color'],
            'id_price' => $price->id_price,
        ]);

        return $variant;
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
        return 'Product Variant berhasil dibuat!';
    }
}