<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating customers and addresses...');

        // Data customer yang akan dibuat
        $customersData = [
            [
                'email' => 'customer1@example.com',
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'no_telepon' => '081234567890',
                'tanggal_lahir' => '1995-03-15',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Merdeka No. 123, RT 02/RW 05',
                    'kota' => 'Surabaya',
                    'provinsi' => 'Jawa Timur', 
                    'kode_pos' => '60234',
                    'patokan' => 'Dekat Masjid Al-Ikhlas, sebelah warung Bu Siti'
                ]
            ],
            [
                'email' => 'customer2@example.com',
                'nama_lengkap' => 'Siti Nurhaliza Dewi',
                'no_telepon' => '082345678901',
                'tanggal_lahir' => '1992-07-22',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Gatot Subroto No. 456, RT 01/RW 03',
                    'kota' => 'Jakarta Selatan',
                    'provinsi' => 'DKI Jakarta',
                    'kode_pos' => '12950',
                    'patokan' => 'Depan Alfamart, belakang Puskesmas'
                ]
            ],
            [
                'email' => 'customer3@example.com',
                'nama_lengkap' => 'Budi Santoso Wijaya',
                'no_telepon' => '083456789012',
                'tanggal_lahir' => '1988-11-08',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Diponegoro No. 789, RT 04/RW 02',
                    'kota' => 'Bandung',
                    'provinsi' => 'Jawa Barat',
                    'kode_pos' => '40112',
                    'patokan' => 'Samping Rumah Sakit Umum, dekat ATM BCA'
                ]
            ],
            [
                'email' => 'customer4@example.com',
                'nama_lengkap' => 'Maya Sari Indrawati',
                'no_telepon' => '084567890123',
                'tanggal_lahir' => '1990-05-14',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Ahmad Yani No. 321, RT 03/RW 01',
                    'kota' => 'Yogyakarta',
                    'provinsi' => 'DI Yogyakarta',
                    'kode_pos' => '55161',
                    'patokan' => 'Seberang Universitas, dekat warung gudeg'
                ]
            ],
            [
                'email' => 'customer5@example.com',
                'nama_lengkap' => 'Dedi Kurniawan Saputra',
                'no_telepon' => '085678901234',
                'tanggal_lahir' => '1993-09-30',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Sudirman No. 654, RT 05/RW 04',
                    'kota' => 'Medan',
                    'provinsi' => 'Sumatera Utara',
                    'kode_pos' => '20152',
                    'patokan' => 'Dekat Mall Plaza, samping KFC'
                ]
            ],
            [
                'email' => 'john.doe@example.com',
                'nama_lengkap' => 'John Doe Anderson',
                'no_telepon' => '086789012345',
                'tanggal_lahir' => '1987-12-25',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Thamrin No. 987, RT 01/RW 02',
                    'kota' => 'Jakarta Pusat',
                    'provinsi' => 'DKI Jakarta',
                    'kode_pos' => '10310',
                    'patokan' => 'Gedung perkantoran, lantai dasar'
                ]
            ],
            [
                'email' => 'jane.doe@example.com',
                'nama_lengkap' => 'Jane Doe Smith',
                'no_telepon' => '087890123456',
                'tanggal_lahir' => '1991-04-18',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Malioboro No. 147, RT 02/RW 03',
                    'kota' => 'Yogyakarta',
                    'provinsi' => 'DI Yogyakarta',
                    'kode_pos' => '55271',
                    'patokan' => 'Dekat Tugu Jogja, sebelah Batik Shop'
                ]
            ],
            [
                'email' => 'mike.johnson@example.com',
                'nama_lengkap' => 'Michael Johnson',
                'no_telepon' => '088901234567',
                'tanggal_lahir' => '1989-08-05',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Asia Afrika No. 258, RT 06/RW 05',
                    'kota' => 'Bandung',
                    'provinsi' => 'Jawa Barat',
                    'kode_pos' => '40261',
                    'patokan' => 'Depan Gedung Sate, seberang halte bus'
                ]
            ],
            [
                'email' => 'sarah.wilson@example.com',
                'nama_lengkap' => 'Sarah Wilson',
                'no_telepon' => '089012345678',
                'tanggal_lahir' => '1994-01-12',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Hayam Wuruk No. 369, RT 03/RW 02',
                    'kota' => 'Denpasar',
                    'provinsi' => 'Bali',
                    'kode_pos' => '80235',
                    'patokan' => 'Dekat Pura Agung, samping toko oleh-oleh'
                ]
            ],
            [
                'email' => 'david.brown@example.com',
                'nama_lengkap' => 'David Brown',
                'no_telepon' => '081123456789',
                'tanggal_lahir' => '1986-06-28',
                'alamat' => [
                    'alamat_lengkap' => 'Jl. Pahlawan No. 741, RT 04/RW 01',
                    'kota' => 'Makassar',
                    'provinsi' => 'Sulawesi Selatan',
                    'kode_pos' => '90124',
                    'patokan' => 'Samping Pantai Losari, dekat restoran seafood'
                ]
            ],
        ];

        $createdCount = 0;

        foreach ($customersData as $data) {
            // Cari user berdasarkan email
            $user = User::where('email', $data['email'])->first();
            
            if (!$user) {
                $this->command->warn("User with email {$data['email']} not found. Skipping...");
                continue;
            }

            // Cek apakah customer sudah ada
            $existingCustomer = Customer::where('id_user', $user->id_user)->first();
            
            if ($existingCustomer) {
                $this->command->info("Customer for {$data['email']} already exists. Skipping...");
                continue;
            }

            // Buat customer
            $customer = Customer::create([
                'id_user' => $user->id_user,
                'nama_lengkap' => $data['nama_lengkap'],
                'no_telepon' => $data['no_telepon'],
                'tanggal_lahir' => Carbon::parse($data['tanggal_lahir']),
                'profil_picture' => null,
            ]);

            // Buat alamat utama
            CustomerAddress::create([
                'id_customer' => $customer->id_customer,
                'alamat_lengkap' => $data['alamat']['alamat_lengkap'],
                'kota' => $data['alamat']['kota'],
                'provinsi' => $data['alamat']['provinsi'],
                'kode_pos' => $data['alamat']['kode_pos'],
                'patokan' => $data['alamat']['patokan'],
                'alamat_utama' => true,
            ]);

            $createdCount++;
        }

        // Statistik
        $totalCustomers = Customer::count();
        $totalAddresses = CustomerAddress::count();
        
        $this->command->info("✅ Created {$createdCount} new customers");
        $this->command->info("📊 Total: {$totalCustomers} customers with {$totalAddresses} addresses");
    }
}