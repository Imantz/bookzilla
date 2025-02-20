<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\BookSeeder;
use Database\Seeders\PurchaseSeeder;
use Database\Seeders\AuthorBookSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AuthorSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(PurchaseSeeder::class);
        $this->call(AuthorBookSeeder::class);
    }
}
