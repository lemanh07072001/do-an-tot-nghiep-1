<?php

use App\Models\User;
use App\Enums\Status;
use App\Models\Brand;
use App\Models\Label;
use App\Models\Categories;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('sort_description')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->string('avatar');
            $table->string('sku');
            $table->decimal('price', 10, 2);
            $table->decimal('price_sale', 10, 2)->default(0);
            $table->tinyInteger('status')->default(Status::Active);
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Label::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Categories::class)->nullable()->constrained()->nullOnDelete();
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
