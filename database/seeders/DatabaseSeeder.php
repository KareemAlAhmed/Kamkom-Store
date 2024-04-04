<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Message;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Review;
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
        Message::factory(5)->create();
        Review::factory(5)->create();
        Cart::factory(1)->create(["owner_id"=>1]);
        Cart::factory(1)->create(["owner_id"=>2]);
        Cart::factory(1)->create(["owner_id"=>3]);
        Cart::factory(1)->create(["owner_id"=>4]);
        Cart::factory(1)->create(["owner_id"=>5]);
        \App\Models\User::factory(1)->create(["email"=>"karimamer@gmail.com","firstName"=>"karim","secondName"=>"ahmad","password"=>"81258136"]);
        Cart::factory(1)->create(["owner_id"=>6]);
    }
}
