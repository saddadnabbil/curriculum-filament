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
        Schema::create('student_descriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('learning_data_id')->constrained('learning_data')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->foreignId('grading_id')->constrained('gradings')->onDelete('cascade');
            $table->string('description', 200)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_descriptions');
    }
};
