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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_status_id')->nullable()->constrained('employee_statuses')->onDelete('cascade');
            $table->foreignId('employee_unit_id')->nullable()->constrained('employee_units')->onDelete('cascade');
            $table->foreignId('employee_position_id')->nullable()->constrained('employee_positions')->onDelete('cascade');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('cascade');
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->date('permanent_date')->nullable();

            $table->string('fullname', 255);
            $table->string('employee_code', 25);
            $table->string('email')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('number_account', 255)->nullable();
            $table->string('number_fingerprint')->nullable();

            $table->string('number_npwp', 255)->nullable();
            $table->string('name_npwp', 255)->nullable();
            $table->string('number_bpjs_ketenagakerjaan', 255)->nullable();
            $table->string('iuran_bpjs_ketenagakerjaan', 255)->nullable();
            $table->string('number_bpjs_yayasan', 255)->nullable();
            $table->string('number_bpjs_pribadi', 255)->nullable();

            $table->enum('gender', ['1', '2'])->nullable();
            $table->enum('religion', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('place_of_birth', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('address_now')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_school')->nullable();
            $table->string('citizen')->nullable();
            $table->enum('marital_status', ['1', '2', '3', '4'])->nullable();
            $table->string('partner_name')->nullable();
            $table->string('number_of_childern')->nullable();
            $table->string('notes')->nullable();

            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('photo_ktp')->nullable();
            $table->string('photo_npwp')->nullable();
            $table->string('photo_kk')->nullable();
            $table->string('other_document')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
