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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('secondName');
            $table->string('bio');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile_number')->unique();
            $table->string('country');
            $table->string('streetAddress');
            $table->string('province');
            $table->string('city');
            $table->integer('zipcode');
            $table->string('ship_to')->nullable()->default('lebanon');
            $table->string('currency')->nullable()->default('USD');
            $table->string('image_url')->nullable()->default('images.jpg');
            $table->foreignId("blocked_user")->nullable()->constrained("users");
            $table->string('company_name')->nullable();
            $table->string('company_business')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
