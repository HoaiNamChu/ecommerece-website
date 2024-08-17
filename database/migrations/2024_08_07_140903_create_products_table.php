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
            $table->string('product_name');
            $table->string('product_sku')->unique();
            $table->string('product_slug')->unique();
            $table->unsignedDecimal('product_price');
            $table->unsignedDecimal('product_price_sale')->nullable();
            $table->string('product_image')->nullable();
            $table->text('product_short_description')->nullable();
            $table->longText('product_description')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_on_sale')->default(0);
            $table->boolean('is_home')->default(0);
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
