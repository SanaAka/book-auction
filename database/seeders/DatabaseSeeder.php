<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // This method tells Laravel which seeders to run and in what order.
        // First, it creates the Admin, then it creates the 100 Books.
        $this->call([
            AdminUserSeeder::class,
            BookSeeder::class,
        ]);
    }
}