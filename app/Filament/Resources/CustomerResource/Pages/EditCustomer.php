<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

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
        // Load data user untuk edit
        $customer = $this->record;
        if ($customer->user) {
            $data['username'] = $customer->user->username;
            $data['email'] = $customer->user->email;
            // Password tidak dimuat untuk keamanan
        }

        // Load alamat utama customer untuk edit
        $mainAddress = $customer->addresses()->where('alamat_utama', true)->first();
        
        if ($mainAddress) {
            $data['alamat_lengkap'] = $mainAddress->alamat_lengkap;
            $data['kota'] = $mainAddress->kota;
            $data['provinsi'] = $mainAddress->provinsi;
            $data['kode_pos'] = $mainAddress->kode_pos;
            $data['patokan'] = $mainAddress->patokan;
        }

        return $data;
    }

    /**
     * Handle update user, customer, dan alamat utama
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // 1. Update data user jika ada
        if ($record->user) {
            $userData = [
                'username' => $data['username'],
                'email' => $data['email'],
            ];
            
            // Update password hanya jika diisi
            if (!empty($data['password'])) {
                $userData['password'] = $data['password']; // sudah di-hash di form
            }

            $record->user->update($userData);
        }

        // 2. Update data customer (kecuali user dan alamat)
        $customerData = collect($data)->except([
            'username',
            'email', 
            'password',
            'alamat_lengkap', 
            'kota', 
            'provinsi', 
            'kode_pos', 
            'patokan'
        ])->toArray();

        $record->update($customerData);

        // 3. Update alamat utama jika ada
        $mainAddress = $record->addresses()->where('alamat_utama', true)->first();
        
        if ($mainAddress) {
            $addressData = [
                'alamat_lengkap' => $data['alamat_lengkap'],
                'kota' => $data['kota'],
                'provinsi' => $data['provinsi'],
                'kode_pos' => $data['kode_pos'],
                'patokan' => $data['patokan'] ?? null,
            ];

            $mainAddress->update($addressData);
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
        return 'Customer dan alamat berhasil diupdate!';
    }
}