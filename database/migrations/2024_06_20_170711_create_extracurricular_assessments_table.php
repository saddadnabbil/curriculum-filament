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
        Schema::create('extracurricular_assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');
            $table->foreignId('member_extracurricular_id')->constrained('member_extracurriculars')->onDelete('cascade');
            $table->enum('grade', ['A', 'B', 'C', 'D']);
            $table->string('description', 200);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_assessments');
    }
};
