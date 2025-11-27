<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Extra fields for crypto wallet
            $table->decimal('wallet_balance', 15, 2)->default(0); // store as decimal
            $table->string('wallet_address')->nullable(); // user's crypto deposit address

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // soft deletes for users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('users');
    }
};
