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
        Schema::create('employee_positions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('employee_position_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_position_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_positions');
        Schema::dropIfExists('employee_position_user');
    }
};
