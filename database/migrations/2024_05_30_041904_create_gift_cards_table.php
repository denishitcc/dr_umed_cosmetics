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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 100)->nullable();
            $table->decimal('value', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->date('expiry_date')->nullable();
            $table->string('notes')->nullable();
            $table->decimal('remaining_value', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->date('purchase_date')->nullable();
            $table->timestamp('last_used')->nullable();
            $table->string('expired',5)->default('no')->nullable();
            $table->string('cancelled',5)->default('no')->nullable();
            $table->string('purchase_at',100)->nullable();
            $table->string('recipient',100)->nullable();
            $table->timestamps();
            $table->timestamp('cancelled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
