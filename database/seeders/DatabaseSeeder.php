<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Laundry;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk laundries
        $laundries = [
            [
                'id' => Str::uuid(),
                'name' => 'Laundry Bersih Jaya',
                'address' => 'Jl. Mangga No. 123, Jakarta Selatan',
                'phone' => '81234567890',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Laundry Sejahtera',
                'address' => 'Jl. Melati No. 45, Jakarta Pusat',
                'phone' => '87654321098',
            ],
        ];

        foreach ($laundries as $laundry) {
            Laundry::create($laundry);
        }

        // Seeder untuk users
        $users = [
            [
                'id' => Str::uuid(),
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'laundry_id' => $laundries[0]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'laundry_id' => $laundries[0]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'laundry_id' => $laundries[1]['id'],
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Seeder untuk customers
        $customers = [
            [
                'id' => Str::uuid(),
                'name' => 'Siti Rahayu',
                'phone' => '81122334455',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Rudi Hermawan',
                'phone' => '82233445566',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Nina Kusuma',
                'phone' => '83344556677',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Seeder untuk orders
        $orders = [
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[0]['id'],
                'laundry_id' => $laundries[0]['id'],
                'status' => 'washed',
                'type' => 'kiloan',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 3.5,
                'total_price' => 35000,
                'note' => 'Tolong disetrika rapi',
                'order_date' => now(),
            ],
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[1]['id'],
                'laundry_id' => $laundries[1]['id'],
                'status' => 'dried',
                'type' => 'express',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 2.0,
                'total_price' => 40000,
                'note' => 'Pakaian putih dipisah',
                'order_date' => now(),
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
