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
            $table->string('image')->nullable();
            $table->string('product_name');
            $table->string('sku')->unique()->nullable();
            $table->decimal('price', 15, 2);
            $table->unsignedBigInteger('stock');
            $table->enum('status', ['available', 'out_of_stock'])->default('available');
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->text('description');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
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
