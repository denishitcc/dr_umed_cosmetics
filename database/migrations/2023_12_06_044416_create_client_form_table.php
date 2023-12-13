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
        Schema::create('client_form', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_summary_id');
            $table->foreign('form_summary_id')
                ->references('id')
                ->on('form_summary')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('reason_for_consultations', 100)->nullable();
            $table->string('how_long_concern', 10)->nullable();
            $table->integer('age')->nullable(); // Example integer type, adjust as needed
            $table->string('treat', 10)->nullable();
            $table->string('treat_yes', 100)->nullable();
            $table->string('taking_medication', 10)->nullable();
            $table->string('medication_yes', 100)->nullable();
            $table->string('product_taking')->nullable();
            $table->string('ipl_hair_removal')->nullable();
            $table->string('hair_removal_method', 100)->nullable();
            $table->string('sign')->nullable();
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_form');
    }
};
