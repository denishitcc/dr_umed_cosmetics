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
        Schema::create('gift_card_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_card_id')->nullable();
            $table->timestamp('date_time')->nullable();
            $table->string('location_name')->nullable();
            $table->decimal('redeemed_value', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->string('redeemed_value_type',15)->nullable();
            $table->string('redeemed_by', 100)->nullable();
            $table->string('invoice_number')->nullable();
            $table->timestamps();

            $table->foreign('gift_card_id')->references('id')->on('gift_cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_card_transaction');
    }
};
