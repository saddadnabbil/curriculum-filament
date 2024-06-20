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
        Schema::create('plan_formatif_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_data_id')->constrained('learning_data')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->string('code');
            $table->enum('techniques', ['1', '2', '3', '4', '5']);
            $table->integer('weighting');
            $table->timestamps();

            // Teknik Penilaian
            // 1 = Parktik
            // 2 = Projek
            // 3 = Produk
            // 4 = Teknik 1
            // 5 = Teknik 2
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_formatif_values');
    }
};
