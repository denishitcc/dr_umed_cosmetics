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
        Schema::create('walk_in_discount_surcharge', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('walk_in_id')->nullable(); // Define client_id column
            $table->string('discount_surcharge', 100)->nullable(); // Assuming product_discount is a decimal
            $table->string('discount_type', 50)->nullable(); // Assuming product_discount is a decimal
            $table->decimal('discount_amount', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->text('discount_reason')->nullable(); // Example decimal type, adjust as needed

            $table->foreign('walk_in_id')->references('id')->on('walk_in_retail_sale');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walk_in_discount_surcharge');
    }
};
