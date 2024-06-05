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
        Schema::table('users', function (Blueprint $table) {
            $table->date('first_date_appear_on_calnedar')->nullable()->after('calendar_color');
            $table->date('last_date_appear_on_calnedar')->nullable()->after('first_date_appear_on_calnedar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_date_appear_on_calnedar');
            $table->dropColumn('last_date_appear_on_calnedar');
        });
    }
};
