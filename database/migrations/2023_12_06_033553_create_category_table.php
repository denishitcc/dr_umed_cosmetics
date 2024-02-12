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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 100)->nullable();
            $table->unsignedBigInteger('parent_category')->nullable();
            $table->boolean('show_business_summary')->default(true);
            $table->boolean('trigger_when_sold')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
