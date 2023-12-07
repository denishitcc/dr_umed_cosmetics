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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',50)->nullable();
            $table->string('lastname',50)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('email');
            $table->string('phone_number',20)->nullable();
            $table->date('enquiry_date')->nullable();
            $table->date('appointment_date')->nullable();
            $table->string('about_us',50)->nullable();
            $table->string('enquiry_source',50)->nullable();
            $table->string('cosmetic_injectables')->nullable(); 
            $table->string('skin')->nullable();
            $table->string('surgical')->nullable();
            $table->string('body')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
