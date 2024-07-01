<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gradings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->foreignId('member_class_school_id')->constrained('member_class_schools')->onDelete('cascade');
            $table->foreignId('plan_formatif_value_id')->constrained('plan_formatif_values')->onDelete('cascade');
            $table->foreignId('plan_sumatif_value_id')->constrained('plan_sumatif_values')->onDelete('cascade');
            $table->foreignId('learning_data_id')->constrained('learning_data')->onDelete('cascade');
            $table->integer('formatif_technique_1')->nullable();
            $table->integer('formatif_technique_2')->nullable();
            $table->integer('formatif_technique_3')->nullable();
            $table->integer('sumatif_technique_1')->nullable();
            $table->integer('sumatif_technique_2')->nullable();
            $table->integer('sumatif_technique_3')->nullable();
            $table->integer('nilai_akhir')->nullable();
            $table->integer('nilai_revisi')->nullable();
            $table->string('description', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gradings');
    }
};
