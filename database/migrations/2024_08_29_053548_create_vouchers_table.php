<?php

use App\Models\User;
use App\Enums\Status;
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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('discount_type');
            $table->integer('value_reduction');
            $table->integer('unlimited')->default(0);
            $table->integer('time')->default('0');
            $table->integer('limit')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->tinyInteger('status')->default(Status::Active);
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
