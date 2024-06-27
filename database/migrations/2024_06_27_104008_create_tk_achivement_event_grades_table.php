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
        Schema::create('tk_achivement_event_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_class_school_id')->constrained('member_class_schools')->onDelete('cascade');
            $table->foreignId('tk_event_id')->constrained('tk_events')->onDelete('cascade');
            $table->enum('achivement_event', ['C', 'ME', 'I', 'NI'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tk_achivement_event_grades');
    }
};
