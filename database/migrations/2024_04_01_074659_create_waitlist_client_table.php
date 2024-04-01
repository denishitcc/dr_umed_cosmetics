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
        Schema::create('waitlist_client', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // Define client_id column
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('preferred_from_date')->nullable();
            $table->date('preferred_to_date')->nullable();
            $table->text('additional_notes')->nullable();
            $table->text('category_id');
            $table->text('service_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        
            // Define foreign key constraints after columns are defined
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlist_client');
    }
};
