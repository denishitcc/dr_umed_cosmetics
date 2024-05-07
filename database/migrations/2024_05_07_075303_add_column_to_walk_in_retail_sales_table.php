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
        Schema::table('walk_in_retail_sale', function (Blueprint $table) {
            $table->unsignedBigInteger('appt_id')->nullable()->after('location_id');

            $table->foreign('appt_id')->references('id')->on('appointment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('walk_in_retail_sales', function (Blueprint $table) {
            //
        });
    }
};
