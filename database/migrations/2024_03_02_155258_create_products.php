<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string("description");
            $table->string("material");
            $table->string("brand_name");
            $table->integer("price");
            $table->integer("quantity");
            $table->string("color");
            $table->integer("sold_number")->default(0);
            $table->integer("weight");
            $table->string("size");
            $table->integer("reviews_number")->default(0);
            $table->integer("star_number")->default(0);
            $table->string("origin")->nullable()->default("unknown");
            $table->json("images_url");
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
