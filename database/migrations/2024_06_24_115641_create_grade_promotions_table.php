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
        Schema::create('grade_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_school_id')->constrained('class_schools')->onDelete('cascade');
            $table->foreignId('member_class_school_id')->constrained('member_class_schools')->onDelete('cascade');
            $table->string('destination_class', 25)->nullable();
            $table->enum('decision', ['1', '2', '3', '4'])->nullable();
            $table->timestamps();

            // Decision 
            // 1 = Promoted to next grade
            // 2 = Stay in Class
            // 3 = Passed 
            // 4 = Not pass
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_promotions');
    }
};
