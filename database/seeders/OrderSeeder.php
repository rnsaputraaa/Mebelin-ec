<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating orders...');

        $customers = Customer::all();

        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please run CustomerSeeder first.');
            return;
        }

        $ordersData = [];
        $createdCount = 0;

        // Create orders for random customers
        foreach ($customers->take(8) as $customer) {
            $numberOfOrders = rand(1, 3);

            for ($i = 0; $i < $numberOfOrders; $i++) {
                $orderDate = $this->randomDateInRange();
                $orderNumber = $this->generateOrderNumber($orderDate);
                
                $ordersData[] = [
                    'order_number' => $orderNumber,
                    'customer_id' => $customer->id_customer,
                    'total_harga' => 0, // Will be updated in OrderItemSeeder
                    'status_order' => $this->getRandomStatus(),
                    'catatan' => $this->getRandomNote(),
                    'tanggal_order' => $orderDate->format('Y-m-d'),
                    'expired_at' => $orderDate->copy()->addDays(7),
                    'created_at' => $orderDate,
                    'updated_at' => Carbon::now(),
                ];

                $createdCount++;
            }
        }

        // Insert orders
        Order::insert($ordersData);

        $this->command->info("✅ Created {$createdCount} orders");
        $this->showOrderStatistics();
    }

    private function generateOrderNumber(Carbon $date): string
    {
        $prefix = 'ORD';
        $dateStr = $date->format('Ymd');
        $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        return $prefix . $dateStr . $random;
    }

    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $weights = [10, 20, 25, 40, 5]; // Delivered paling banyak
        
        return $this->weightedRandom($statuses, $weights);
    }

    private function getRandomNote(): ?string
    {
        $notes = [
            'Mohon kirim secepatnya',
            'Tolong pack dengan bubble wrap',
            'Alamat rumah di gang kecil',
            'Call dulu sebelum kirim',
            'Kirim sore hari saja',
            null, null, null // 3 null untuk kemungkinan tidak ada catatan
        ];

        return $notes[array_rand($notes)];
    }

    private function weightedRandom(array $values, array $weights): string
    {
        $total = array_sum($weights);
        $random = rand(1, $total);
        
        $currentWeight = 0;
        for ($i = 0; $i < count($values); $i++) {
            $currentWeight += $weights[$i];
            if ($random <= $currentWeight) {
                return $values[$i];
            }
        }
        
        return $values[0];
    }

    private function randomDateInRange(): Carbon
    {
        $startDate = Carbon::now()->subMonths(2);
        $endDate = Carbon::now()->subDays(1);
        
        return Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
    }

    private function showOrderStatistics(): void
    {
        $this->command->info("\n📊 Order Statistics:");
        $orders = Order::all();
        
        $statusCounts = $orders->groupBy('status_order')->map->count();
        foreach ($statusCounts as $status => $count) {
            $this->command->line("  {$status}: {$count} orders");
        }
    }
}
