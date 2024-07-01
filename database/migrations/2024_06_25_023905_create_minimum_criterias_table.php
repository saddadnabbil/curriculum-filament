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
        Schema::create('minimum_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_data_id')->constrained('learning_data')->onDelete('cascade');
            $table->foreignId('class_school_id')->constrained('class_schools')->onDelete('cascade');
            $table->integer('kkm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minimum_criterias');
    }
};
