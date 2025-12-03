<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // NOWPayments fields
            $table->string('payment_id')->unique();      // returned from API
            $table->string('order_id');                  // wallet_123_ timestamp
            $table->string('pay_currency');              // BTC, USDT, etc.
            $table->decimal('price_amount', 15, 2);      // USD amount
            $table->decimal('pay_amount', 20, 8)->nullable(); // crypto to send
            $table->string('pay_address')->nullable();   // generated address

            $table->string('status')->default('waiting'); // waiting, confirming, finished, failed...

            $table->decimal('actually_paid', 20, 8)->nullable(); // from API
            $table->string('network')->nullable();               // optional

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
