<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Laundry;
use App\Models\Order;
use App\Models\Service;
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

        // Seeder untuk services
        $services = [
            // Services untuk Laundry Bersih Jaya
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[0]['id'],
                'name' => 'Kiloan',
                'description' => 'Cuci dan setrika per kilogram, selesai dalam 2 hari',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[0]['id'],
                'name' => 'Express',
                'description' => 'Cuci dan setrika cepat, selesai dalam 24 jam',
            ],
            // Services untuk Laundry Sejahtera
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[1]['id'],
                'name' => 'Satuan',
                'description' => 'Cuci dan setrika per potong pakaian',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[1]['id'],
                'name' => 'Regular',
                'description' => 'Cuci standar, selesai dalam 3 hari',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
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
                'role' => 'staff',
                'laundry_id' => $laundries[1]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Ridlo',
                'email' => 'ridlo@gmail.com',
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
                'service_id' => $services[0]['id'], // Kiloan dari Laundry Bersih Jaya
                'status' => 'washed',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 3.5,
                'total_price' => 35000, // 3.5 kg * 10000
                'note' => 'Tolong disetrika rapi',
                'order_date' => now(),
            ],
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[1]['id'],
                'laundry_id' => $laundries[1]['id'],
                'service_id' => $services[2]['id'], // Satuan dari Laundry Sejahtera
                'status' => 'dried',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 2.0,
                'total_price' => 10000, // 2 item * 5000
                'note' => 'Pakaian putih dipisah',
                'order_date' => now(),
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
