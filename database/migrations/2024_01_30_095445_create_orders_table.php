<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('checkout_token')->unique();
            $table->float('checkout_shipping')->default(0.2);
            $table->decimal('checkout_total', 8, 2);
            $table->decimal('checkout_total_with_shipping', 8, 2);
            // email and phone number
            $table->string('checkout_email');
            $table->string('checkout_phone_number');

            //order state
            $table->enum('checkout_status', ['pending', 'processing', 'completed'])->default('pending');

            // user details
            $table->string('checkout_first_name');
            $table->string('checkout_last_name');
            $table->text('checkout_address');
            $table->string('checkout_city');
            $table->string('checkout_country')->default('poland');

            //payment
            $table->enum('checkout_payment_method', ['cash', 'credit_card'])->default('credit_card');
            $table->string('checkout_card_number')->nullable();
            $table->string('checkout_expire_date_month')->nullable();
            $table->string('checkout_expire_date_year')->nullable();
            $table->string('checkout_security_code')->nullable();

            $table->foreignId('shawermakrakows_id')->default(1)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
