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
        Schema::create('walk_in_retail_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable(); // Define client_id column
            $table->unsignedBigInteger('location_id')->nullable(); // Define client_id column
            $table->date('invoice_date')->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable(); // Assuming product_discount is a decimal
            $table->decimal('gst', 10, 2)->nullable(); // Assuming product_discount is a decimal
            $table->decimal('total', 10, 2)->nullable(); // Assuming product_discount is a decimal
            $table->decimal('remaining_balance', 10, 2)->nullable(); // Assuming product_discount is a decimal
            $table->unsignedBigInteger('user_id')->nullable(); // Define client_id column
            $table->text('note')->nullable();
            $table->string('customer_type', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Define foreign key constraints after columns are defined
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walk_in_retail_sale');
    }
};