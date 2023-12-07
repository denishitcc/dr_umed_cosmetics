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
        Schema::create('form_summary', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable(); // Changed to 'text' type for potentially longer descriptions
            $table->string('by_whom', 50)->nullable();
            $table->string('status', 50)->nullable(); // Marked as nullable, consider using enumerations
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_summary');
    }
};
