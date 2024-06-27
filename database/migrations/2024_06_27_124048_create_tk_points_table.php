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
        Schema::create('tk_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tk_topic_id')->constrained('tk_topics')->onDelete('cascade');
            $table->foreignId('tk_subtopic_id')->nullable()->constrained('tk_subtopics')->onDelete('cascade');
            $table->foreignId('term_id')->nullable()->constrained('terms')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tk_points');
    }
};
