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
            $table->string('walk_in_type',50)->nullable()->after('customer_type'); // Replace 'column_name' with the name of the column after which you want to add the new column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('walk_in_retail_sale', function (Blueprint $table) {
            //
        });
    }
};
