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
            $table->string('name');
            $table->string('description');
            $table->string('category');
            $table->integer('quantity');
            $table->boolean('availability')->default(true);
            $table->boolean('top_product')->default(false);
            $table->float('weight');
            $table->float('price_before_discount');
            $table->float('price_after_discount')->nullable();
            $table->string('image');
            $table->foreignId('shawermakrakows_id')->constrained();
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
