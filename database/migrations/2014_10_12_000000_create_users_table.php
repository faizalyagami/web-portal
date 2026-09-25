<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // === AUTH ===
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // === TIPE USER ===
            $table->enum('user_type', ['mahasiswa', 'dosen', 'staff', 'admin'])
                ->default('mahasiswa');

            // === IDENTIFIER (NPM / NIDN / NIK) ===
            $table->string('identifier')->nullable()->unique()
                ->comment('NPM untuk mahasiswa, NIDN/NIK untuk dosen/staff');
            $table->string('nidn')->nullable()->comment('Khusus dosen');
            $table->string('nik')->nullable()->comment('Khusus staff');

            // === DATA AKADEMIK ===
            $table->string('fakultas')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('jabatan')->nullable()
                ->comment('Jabatan struktural/akademik');

            // === KONTAK & PROFIL ===
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('angkatan')->nullable()->comment('Khusus mahasiswa');

            // === STATUS ===
            $table->boolean('is_active')->default(true);
            $table->boolean('is_super_admin')->default(false);
            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();

            // === INDEX ===
            $table->index('user_type');
            $table->index('fakultas');
            $table->index('program_studi');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
