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
        Schema::create('students', function (Blueprint $table) {
            // student information
            $table->id();

            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('class_schools')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->foreignId('line_id')->constrained('lines')->onDelete('cascade');

            $table->enum('jenis_pendaftaran', ['1', '2']);
            $table->string('tahun_masuk')->nullable();
            $table->string('semester_masuk')->nullable();
            $table->string('kelas_masuk')->nullable();

            $table->string('nis', 10)->unique();
            $table->string('nisn', 10)->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('nama_panggilan', 100);
            $table->string('nik', 16)->nullable();
            $table->enum('jenis_kelamin', ['MALE', 'FEMALE']);
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->enum('agama', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('anak_ke', 2)->nullable();
            $table->string('jml_saudara_kandung', 2)->nullable();
            $table->string('warga_negara')->nullable();
            $table->string('pas_photo')->nullable();

            // domicile information
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->unsignedInteger('kode_pos')->nullable();
            $table->unsignedInteger('jarak_rumah_ke_sekolah')->nullable();
            $table->string('email_parent')->nullable();
            $table->string('nomor_hp', 13)->nullable();
            $table->enum('tinggal_bersama', ['Parents', 'Others'])->nullable();
            $table->string('transportasi')->nullable();

            //// parent information
            // parent information father
            $table->string('nik_ayah', 16)->nullable();
            $table->string('nama_ayah', 100)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('alamat_ayah', 100)->nullable();
            $table->string('nomor_hp_ayah', 13)->nullable();
            $table->enum('agama_ayah', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('kota_ayah', 100)->nullable();
            $table->string('pendidikan_terakhir_ayah', 25)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('penghasil_ayah', 100)->nullable();
            // parent information mother
            $table->string('nik_ibu', 16)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('alamat_ibu', 100)->nullable();
            $table->string('nomor_hp_ibu', 13)->nullable();
            $table->enum('agama_ibu', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('kota_ibu', 100)->nullable();
            $table->string('pendidikan_terakhir_ibu', 25)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('penghasil_ibu', 100)->nullable();
            // parent information guardian
            $table->string('nik_wali', 16)->nullable();;
            $table->string('nama_wali', 100)->nullable();;
            $table->string('tempat_lahir_wali', 100)->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('alamat_wali', 100)->nullable();
            $table->string('nomor_hp_wali', 13)->nullable();
            $table->enum('agama_wali', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('kota_wali', 100)->nullable();
            $table->string('pendidikan_terakhir_wali', 25)->nullable();
            $table->string('pekerjaan_wali', 100)->nullable();
            $table->string('penghasil_wali', 100)->nullable();

            // student medical condition information
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('spesial_treatment')->nullable();
            $table->string('note_kesehatan')->nullable();
            $table->string('file_document_kesehatan')->nullable();
            $table->string('file_list_pertanyaan')->nullable();

            // previeously formal school
            $table->date('tanggal_masuk_sekolah_lama')->nullable();
            $table->date('tanggal_keluar_sekolah_lama')->nullable();
            $table->string('nama_sekolah_lama', 100)->nullable();
            $table->string('prestasi_sekolah_lama', 100)->nullable();
            $table->string('tahun_prestasi_sekolah_lama', 100)->nullable();
            $table->string('sertifikat_number_sekolah_lama', 100)->nullable();
            $table->string('alamat_sekolah_lama', 100)->nullable();
            $table->string('no_sttb')->nullable();
            $table->unsignedInteger('nem')->nullable();
            $table->string('file_dokument_sekolah_lama')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
