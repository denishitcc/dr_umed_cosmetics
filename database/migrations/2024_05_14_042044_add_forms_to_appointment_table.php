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
        Schema::table('appointment', function (Blueprint $table) {
            $table->string('forms')->nullable()->after('location_id');
            $table->string('forms_sent_sms')->nullable()->after('forms');
            $table->string('forms_sent_email')->nullable()->after('forms_sent_sms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn('forms');
        });
    }
};
