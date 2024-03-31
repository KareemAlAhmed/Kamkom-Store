<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();
        Product::factory(5)->create();
        Category::factory(5)->create();
        Purchase::factory(5)->create();
        \App\Models\User::factory(1)->create(["email"=>"karimamer@gmail.com","firstName"=>"karim","secondName"=>"ahmad","password"=>"81258136"]);
    }
}
