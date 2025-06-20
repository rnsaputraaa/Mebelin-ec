<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    /**
     * Mutasi data form sebelum disimpan ke database.
     * Digunakan untuk menghasilkan slug otomatis jika belum disediakan.
     */

     
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['slug']) && !empty($data['category_name'])) {
            $data['slug'] = Str::slug($data['category_name']);
        }

        return $data;
    }

    /**
     * Redirect ke halaman index setelah berhasil membuat data.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Menampilkan notifikasi ketika kategori berhasil dibuat.
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Kategori berhasil dibuat!';
    }
}
