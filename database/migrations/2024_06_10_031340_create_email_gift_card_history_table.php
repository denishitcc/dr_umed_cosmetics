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
        Schema::create('email_gift_card_history', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number');
            $table->string('email');
            $table->string('sent_by',255)->nullable();
            $table->timestamp('send_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_gift_card_history');
    }
};
