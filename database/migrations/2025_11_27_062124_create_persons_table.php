<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();

            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('country')->nullable();
            $table->string('email')->nullable();
            $table->string('emailPass')->nullable();
            $table->string('faUname')->nullable();
            $table->string('faPass')->nullable();
            $table->string('backupCode')->nullable();
            $table->string('securityQa')->nullable();
            $table->string('state')->nullable();
            $table->string('gender')->nullable();
            $table->string('zip')->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('ssn')->nullable();
            $table->string('cs')->nullable();
            $table->string('city')->nullable();
            $table->date('purchaseDate')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('persons');
    }
};
