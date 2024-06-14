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
        Schema::create('member_extracurriculars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_class_school_id')->constrained('member_class_schools')->onDelete('cascade');
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_extracurriculars');
    }
};
