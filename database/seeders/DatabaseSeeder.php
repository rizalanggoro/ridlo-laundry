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
                'name' => 'Laundry Almada',
                'address' => 'Jl. Surakarta No. 123, Surakarta',
                'phone' => '081234567890',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Laundry Sejahtera',
                'address' => 'Jl. Melati No. 45, Jakarta Pusat',
                'phone' => '087654321098',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Laundry Bersih',
                'address' => 'Jl. Mawar No. 78, Bandung',
                'phone' => '085123456789',
            ],
        ];

        foreach ($laundries as $laundry) {
            Laundry::create($laundry);
        }

        // Seeder untuk services
        $services = [
            // Services untuk Laundry Almada
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[0]['id'],
                'name' => 'Satuan',
                'description' => 'Cuci dan setrika per potong pakaian',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[0]['id'],
                'name' => 'Kiloan',
                'description' => 'Cuci dan setrika per kilogram, selesai dalam 2 hari',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[0]['id'],
                'name' => 'Regular',
                'description' => 'Cuci standar, selesai dalam 3 hari',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[0]['id'],
                'name' => 'Express',
                'description' => 'Cuci dan setrika cepat, selesai dalam 24 jam',
            ],
            // Services untuk Laundry Sejahtera (dummy)
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[1]['id'],
                'name' => 'Kiloan',
                'description' => 'Cuci per kilogram, selesai dalam 2 hari',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[1]['id'],
                'name' => 'Express',
                'description' => 'Layanan cepat, selesai dalam 1 hari',
            ],
            // Services untuk Laundry Bersih (dummy)
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[2]['id'],
                'name' => 'Satuan',
                'description' => 'Cuci per potong pakaian',
            ],
            [
                'id' => Str::uuid(),
                'laundry_id' => $laundries[2]['id'],
                'name' => 'Regular',
                'description' => 'Cuci standar, selesai dalam 3 hari',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Seeder untuk users
        $users = [
            // Users untuk Laundry Almada
            [
                'id' => Str::uuid(),
                'name' => 'Owner',
                'email' => 'owner@almadalaundry.com',
                'password' => Hash::make('almadalaundry2025'),
                'role' => 'owner',
                'laundry_id' => $laundries[0]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@almadalaundry.com',
                'password' => Hash::make('almadalaundry2025'),
                'role' => 'owner',
                'laundry_id' => $laundries[0]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Staff 1',
                'email' => 'staff1@almadalaundry.com',
                'password' => Hash::make('almadalaundry2025'),
                'role' => 'staff',
                'laundry_id' => $laundries[0]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Staff 2',
                'email' => 'staff2@almadalaundry.com',
                'password' => Hash::make('almadalaundry2025'),
                'role' => 'staff',
                'laundry_id' => $laundries[0]['id'],
            ],
            // Users untuk Laundry Sejahtera (dummy)
            [
                'id' => Str::uuid(),
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@sejahtera.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'laundry_id' => $laundries[1]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Budi Santoso',
                'email' => 'budi@sejahtera.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'laundry_id' => $laundries[1]['id'],
            ],
            // Users untuk Laundry Bersih (dummy)
            [
                'id' => Str::uuid(),
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@bersih.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'laundry_id' => $laundries[2]['id'],
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Dewi Lestari',
                'email' => 'dewi@bersih.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'laundry_id' => $laundries[2]['id'],
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
                'phone' => '081122334455',
                'username' => 'sitirahayu',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Rudi Hermawan',
                'phone' => '082233445566',
                'username' => 'rudihermawan',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Nina Kusuma',
                'phone' => '083344556677',
                'username' => 'ninakusuma',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Seeder untuk orders
        $orders = [
            // Order untuk Laundry Almada
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[0]['id'],
                'laundry_id' => $laundries[0]['id'],
                'service_id' => $services[1]['id'], // Kiloan dari Laundry Almada
                'status' => 'washed',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 3.5,
                'total_price' => 35000, // Misal: 3.5 kg * 10000
                'note' => 'Tolong disetrika rapi',
                'order_date' => now(),
            ],
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[1]['id'],
                'laundry_id' => $laundries[0]['id'],
                'service_id' => $services[3]['id'], // Express dari Laundry Almada
                'status' => 'dried',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 2.0,
                'total_price' => 30000, // Misal: 2 kg * 15000 (express lebih mahal)
                'note' => 'Pakaian putih dipisah',
                'order_date' => now(),
            ],
            // Order untuk Laundry Sejahtera (dummy)
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[2]['id'],
                'laundry_id' => $laundries[1]['id'],
                'service_id' => $services[4]['id'], // Kiloan dari Laundry Sejahtera
                'status' => 'pending',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 4.0,
                'total_price' => 40000, // Misal: 4 kg * 10000
                'note' => 'Cuci dengan deterjen lembut',
                'order_date' => now(),
            ],
            // Order untuk Laundry Bersih (dummy)
            [
                'id' => Str::uuid(),
                'customer_id' => $customers[0]['id'],
                'laundry_id' => $laundries[2]['id'],
                'service_id' => $services[6]['id'], // Satuan dari Laundry Bersih
                'status' => 'completed',
                'barcode' => 'ORD-' . Str::random(8),
                'weight' => 0.0, // Satuan tidak pakai berat
                'total_price' => 15000, // Misal: 3 item * 5000
                'note' => 'Jaket bulu hati-hati',
                'order_date' => now(),
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
