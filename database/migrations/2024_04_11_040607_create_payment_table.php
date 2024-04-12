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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walk_in_id')->nullable(); // Define client_id column
            $table->string('payment_type', 50)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->date('date')->nullable();
            $table->decimal('total', 10, 2)->nullable(); // Assuming product_discount is a decimal
            $table->decimal('remaining_balance', 10, 2)->nullable(); // Assuming product_discount is a decimal

            $table->softDeletes();
            $table->timestamps();

            // Define foreign key constraints after columns are defined
            $table->foreign('walk_in_id')->references('id')->on('walk_in_retail_sale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_');
    }
};
