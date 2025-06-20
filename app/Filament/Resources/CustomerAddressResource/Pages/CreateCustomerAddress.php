<?php

namespace App\Filament\Resources\CustomerAddressResource\Pages;

use App\Filament\Resources\CustomerAddressResource;
use App\Models\CustomerAddress;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateCustomerAddress extends CreateRecord
{
    protected static string $resource = CustomerAddressResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Alamat customer berhasil ditambahkan!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika alamat ini dijadikan utama, set alamat lain menjadi tidak utama
        if ($data['alamat_utama']) {
            CustomerAddress::where('id_customer', $data['id_customer'])
                ->update(['alamat_utama' => false]);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $customer = $this->record->customer;
        
        Notification::make()
            ->title('Alamat Berhasil Ditambahkan!')
            ->body("Alamat baru untuk customer {$customer->nama_lengkap} telah berhasil ditambahkan.")
            ->success()
            ->duration(5000)
            ->send();
    }
}