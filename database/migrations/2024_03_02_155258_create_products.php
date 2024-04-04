<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpOption\None;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("brand_name");
            $table->float("price");
            $table->integer("quantity");
            $table->integer("sold_number")->default(0);
            $table->integer("reviews_number")->default(0);
            $table->integer("star_number")->default(0);
            $table->json("specs");
            $table->json("images_url");
            $table->string("thumbnail_url")->default("images.png");
            $table->foreignId("category_id");
            $table->foreignId("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
