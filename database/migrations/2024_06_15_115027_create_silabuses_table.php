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
        Schema::create('silabuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_school_id')->constrained('class_schools')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');

            $table->string('k_tigabelas')->nullable();
            $table->string('cambridge')->nullable();
            $table->string('edexcel')->nullable();
            $table->string('book_indo_siswa')->nullable();
            $table->string('book_english_siswa')->nullable();
            $table->string('book_indo_guru')->nullable();
            $table->string('book_english_guru')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('silabuses');
    }
};
