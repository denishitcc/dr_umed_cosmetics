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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Example decimal type, adjust as needed
            $table->decimal('cost', 10, 2)->nullable();  // Example decimal type, adjust as needed
            $table->string('type', 100)->nullable();
            $table->string('gst_code', 100)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('supplier_code', 50)->nullable();
            $table->string('barcode_1', 50)->nullable();
            $table->string('barcode_2', 50)->nullable();
            $table->string('order_lot', 50)->nullable();
            $table->string('min', 50)->nullable();
            $table->string('max', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
