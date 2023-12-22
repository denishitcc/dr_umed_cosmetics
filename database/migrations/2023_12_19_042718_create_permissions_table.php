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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name, 100')->nullable();
            $table->string('appointments_and_clients, 100')->nullable();
            $table->boolean('targets')->default(false);
            $table->boolean('limited')->default(false);
            $table->boolean('standard')->default(false);
            $table->boolean('standard+')->default(false);
            $table->boolean('advance')->default(false);
            $table->boolean('advance+')->default(false);
            $table->boolean('accounts')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
