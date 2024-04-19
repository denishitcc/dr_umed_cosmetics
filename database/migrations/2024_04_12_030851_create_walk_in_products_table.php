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
        Schema::create('walk_in_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walk_in_id')->nullable(); // Define client_id column
            $table->text('product_id')->nullable();
            $table->string('product_name', 100)->nullable();
            $table->decimal('product_price', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->string('product_quantity', 50)->nullable();
            $table->string('product_type', 50)->nullable();
            $table->unsignedBigInteger('who_did_work')->nullable(); // Define client_id column
            $table->string('product_discount_surcharge', 100)->nullable(); // Assuming product_discount is a decimal
            $table->string('discount_type', 50)->nullable(); // Assuming product_discount is a decimal
            $table->decimal('discount_amount', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->text('discount_reason')->nullable(); // Example decimal type, adjust as needed
            $table->string('type',50)->nullable(); // Example decimal type, adjust as needed
            $table->decimal('discount_value', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('walk_in_id')->references('id')->on('walk_in_retail_sale');
            $table->foreign('who_did_work')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walk_in_products');
    }
};
