<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoOrdersSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::inRandomOrder()->take(20)->get();
        if ($products->isEmpty()) {
            $this->command?->warn('No products found, skipping orders seeding.');
            return;
        }

        // базовий адмін та кілька клієнтів
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ]
        );

        $customers = collect([
            ['name' => 'Oleh Ivanko', 'email' => 'oleh@example.com'],
            ['name' => 'Dasha Kross', 'email' => 'dasha@example.com'],
            ['name' => 'Maksym Drop', 'email' => 'maksym@example.com'],
            ['name' => 'Iryna Run', 'email' => 'iryna@example.com'],
            ['name' => 'Guest Sneaker', 'email' => 'guest@example.com'],
        ])->map(function ($user) {
            return User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => bcrypt('password'),
                    'role' => 'user',
                ]
            );
        });

        $statuses = ['new', 'paid', 'shipped', 'cancelled'];
        $paymentMethods = ['card', 'cod', 'paypal'];

        foreach ($customers as $customer) {
            $ordersToCreate = rand(2, 4);

            for ($i = 0; $i < $ordersToCreate; $i++) {
                $createdAt = Carbon::now()->subDays(rand(0, 90))->setTime(rand(8, 22), rand(0, 59));
                $order = Order::create([
                    'user_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'customer_phone' => '+380' . rand(670000000, 689999999),
                    'customer_address' => 'Kyiv, Demo street ' . rand(1, 99),
                    'total_price' => 0, // перерахуємо після itemів
                    'status' => $statuses[array_rand($statuses)],
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $itemsCount = rand(1, 3);
                $total = 0;

                for ($j = 0; $j < $itemsCount; $j++) {
                    $product = $products->random();
                    $qty = rand(1, 2);
                    $total += $product->price * $qty;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $product->price,
                    ]);
                }

                $order->update(['total_price' => $total]);
            }
        }

        $this->command?->info('Demo orders seeded: ' . Order::count());
    }
}
