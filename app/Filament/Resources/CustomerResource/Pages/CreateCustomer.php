<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    /**
     * Handle pembuatan user, customer, dan alamat sekaligus
     */
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Buat User account terlebih dahulu
        $userData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // sudah di-hash di form
            'u_type' => 'customer',
        ];

        $user = User::create($userData);

        // 2. Siapkan data customer (hapus data user dan alamat)
        $customerData = [
            'id_user' => $user->id_user, // PENTING: Tambahkan id_user
            'nama_lengkap' => $data['nama_lengkap'],
            'no_telepon' => $data['no_telepon'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'profil_picture' => $data['profil_picture'] ?? null,
        ];

        // 3. Buat customer
        $customer = Customer::create($customerData);

        // 4. Buat alamat utama untuk customer
        $addressData = [
            'id_customer' => $customer->id_customer,
            'alamat_lengkap' => $data['alamat_lengkap'],
            'kota' => $data['kota'],
            'provinsi' => $data['provinsi'],
            'kode_pos' => $data['kode_pos'],
            'patokan' => $data['patokan'] ?? null,
            'alamat_utama' => true, // Alamat pertama otomatis jadi alamat utama
        ];

        CustomerAddress::create($addressData);

        return $customer;
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
        return 'User account, customer, dan alamat berhasil dibuat!';
    }
}