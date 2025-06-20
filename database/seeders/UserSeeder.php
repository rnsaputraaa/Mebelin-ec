<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating users...');

        // 1. Admin User (sudah ada dari SQL dump, tapi kita pastikan ada)
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'u_type' => 'admin',
                'email_verified' => now(),
            ]
        );

        // 2. Sample Customer Users (untuk customer yang sudah ada di SQL dump)
        $customerUsers = [
            [
                'username' => 'customer1',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'customer2', 
                'email' => 'customer2@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'customer3',
                'email' => 'customer3@example.com', 
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'customer4',
                'email' => 'customer4@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'customer5',
                'email' => 'customer5@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'johndoe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'janedoe',
                'email' => 'jane.doe@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'mikejohnson',
                'email' => 'mike.johnson@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'sarahwilson',
                'email' => 'sarah.wilson@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
            [
                'username' => 'davidbrown',
                'email' => 'david.brown@example.com',
                'password' => Hash::make('password'),
                'u_type' => 'customer',
            ],
        ];

        foreach ($customerUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $totalUsers = User::count();
        $adminCount = User::where('u_type', 'admin')->count();
        $customerCount = User::where('u_type', 'customer')->count();

        $this->command->info("✅ Created {$totalUsers} users (Admin: {$adminCount}, Customer: {$customerCount})");
    }
}