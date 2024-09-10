<?php

use App\Models\Products;
use App\Models\GroupProduct;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_product_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Products::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(GroupProduct::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_product_products');
    }
};
