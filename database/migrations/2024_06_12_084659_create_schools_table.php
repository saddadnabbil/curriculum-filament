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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();

            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');

            $table->string('school_name', 100);
            $table->string('npsn', 10);
            $table->string('nss', 15)->nullable();
            $table->string('postal_code', 5);
            $table->string('number_phone', 13)->nullable();
            $table->string('address');
            $table->string('website', 100)->nullable();
            $table->string('email', 35)->nullable();
            $table->string('logo')->default('public/logo.png');
            $table->string('principal', 100);
            $table->string('nip_principal', 18);
            $table->string('signature_principal')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
