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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status');

            $table->foreignId('employee_status_id')->constrained('employee_statuses')->onDelete('cascade')->nullable();
            $table->foreignId('employee_unit_id')->constrained('employee_units')->onDelete('cascade')->nullable();
            $table->foreignId('employee_position_id')->constrained('employee_positions')->onDelete('cascade')->nullable();
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->date('permanent_date')->nullable();

            $table->string('kode_karyawan', 25)->nullable();
            $table->string('nama_lengkap', 255);
            $table->string('nik', 16)->nullable();
            $table->string('nomor_akun', 255)->nullable();
            $table->string('nomor_fingerprint')->nullable();

            $table->string('nomor_taxpayer', 255)->nullable();
            $table->string('nama_taxpayer', 255)->nullable();
            $table->string('nomor_bpjs_ketenagakerjaan', 255)->nullable();
            $table->string('iuran_bpjs_ketenagakerjaan', 255)->nullable();
            $table->string('nomor_bpjs_yayasan', 255)->nullable();
            $table->string('nomor_bpjs_pribadi', 255)->nullable();

            $table->enum('jenis_kelamin', ['1', '2']);
            $table->enum('agama', ['1', '2', '3', '4', '5', '6', '7']);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('alamat_sekarang')->nullable();
            $table->string('kota')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nomor_phone')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email_sekolah')->nullable();
            $table->string('warga_negara')->nullable();
            $table->enum('status_pernikahan', ['1', '2', '3', '4'])->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->string('jumlah_anak')->nullable();
            $table->string('keterangan')->nullable();

            $table->string('pas_photo')->nullable();
            $table->string('ttd')->nullable();
            $table->string('photo_kartu_identitas')->nullable();
            $table->string('photo_taxpayer')->nullable();
            $table->string('photo_kk')->nullable();
            $table->string('other_document')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
