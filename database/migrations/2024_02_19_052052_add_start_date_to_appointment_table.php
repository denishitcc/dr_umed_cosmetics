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
            $table->unsignedBigInteger('staff_id')->nullable()->after('service_id');
            $table->timestamp('start_date')->nullable()->after('staff_id');
            $table->timestamp('end_date')->nullable()->after('start_date');
            $table->integer('duration')->after('end_date');
            $table->bigInteger('status')->comment('1=Booked,2=Confirmed,3=Started,4=Completed,5=No answer,6=Left message,7=Pencilied in,8=Turned up,9=No show,10=Cancelled')->after('duration');

            $table->foreign('staff_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('duration');
            $table->dropColumn('status');
        });
    }
};
