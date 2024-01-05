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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',50)->nullable();
            $table->string('lastname',50)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('email');
            $table->date('date_of_birth')->nullable();
            $table->string('mobile_number',20)->nullable();
            $table->string('home_phone',20)->nullable();
            $table->string('work_phone',20)->nullable();
            $table->string('contact_method',50)->nullable();
            $table->tinyInteger('send_promotions')->default(0); // Representing boolean with TINYINT(1)
            $table->string('street_address',100)->nullable();
            $table->string('suburb',100)->nullable();
            $table->string('city',50)->nullable();
            $table->string('postcode',10)->nullable();
            $table->string('status',50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
