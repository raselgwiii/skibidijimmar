<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Explicitly Add an Admin User
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('russel123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Additional Users with Realistic Usernames and Emails
        DB::table('users')->insert(
            collect(range(21, 40))->map(function ($i) {
                $firstNames = ['john', 'jane', 'michael', 'sarah', 'alex', 'linda', 'robert', 'emily', 'david', 'laura'];
                $lastNames = ['smith', 'johnson', 'williams', 'brown', 'jones', 'garcia', 'martinez', 'rodriguez', 'lee', 'taylor'];
                $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'example.org'];

                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $username = "{$firstName}.{$lastName}{$i}";
                $email = "{$firstName}.{$lastName}{$i}@" . $domains[array_rand($domains)];

                return [
                    'username' => $username,
                    'email' => strtolower($email),
                    'password' => bcrypt('password'),
                    'role' => $i % 2 === 0 ? 'customer' : 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Categories
        DB::table('categories')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'name' => 'Category ' . $i,
                    'description' => 'Another description for Category ' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Products
        DB::table('products')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'name' => 'Product ' . $i,
                    'description' => 'Another description for Product ' . $i,
                    'price' => rand(200, 2000) / 10,
                    'stock_quantity' => rand(10, 200),
                    'category_id' => rand(21, 40),
                    'image_url' => 'https://via.placeholder.com/150',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Cart Items
        DB::table('cart')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'user_id' => rand(21, 40),
                    'product_id' => rand(21, 40),
                    'quantity' => rand(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Orders
        DB::table('orders')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'user_id' => rand(21, 40),
                    'order_number' => Str::random(10),
                    'total_amount' => rand(2000, 20000) / 10,
                    'status' => ['pending', 'completed', 'shipped', 'canceled'][array_rand(['pending', 'completed', 'shipped', 'canceled'])],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Order Items
        DB::table('order_items')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'order_id' => rand(21, 40),
                    'product_id' => rand(21, 40),
                    'quantity' => rand(1, 10),
                    'price' => rand(200, 2000) / 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Payments
        DB::table('payments')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'order_id' => rand(21, 40),
                    'payment_method' => ['credit_card', 'paypal', 'bank_transfer'][array_rand(['credit_card', 'paypal', 'bank_transfer'])],
                    'amount' => rand(2000, 20000) / 10,
                    'status' => ['success', 'failed', 'pending'][array_rand(['success', 'failed', 'pending'])],
                    'payment_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );

        // Seed Additional Inventory Adjustments
        DB::table('inventory_adjustments')->insert(
            collect(range(21, 40))->map(function ($i) {
                return [
                    'product_id' => rand(21, 40),
                    'adjustment_type' => ['add', 'remove'][array_rand(['add', 'remove'])],
                    'quantity' => rand(1, 100),
                    'reason' => 'Extra Reason ' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );
    }
}
