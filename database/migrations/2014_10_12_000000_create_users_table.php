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
        // User
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->timestamps();
        });

        // Profile
        Schema::create('profiles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->timestamps();
        });

        // Provinsi
        Schema::create('provinces', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->timestamps();
        });

        // Kabupaten
        Schema::create('districts', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->foreignId('province_id')->constrained()->onDelete('cascade'); // Relasi ke provinces
            $table->timestamps();
        });

        // Kecamatan
        Schema::create('subdistricts', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->foreignId('district_id')->constrained()->onDelete('cascade'); // Relasi ke districts
            $table->timestamps();
        });

        // Desa
        Schema::create('villages', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->foreignId('subdistrict_id')->constrained()->onDelete('cascade'); // Relasi ke subdistricts
            $table->timestamps();
        });

        // Kode Pos
        Schema::create('postal_codes', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('code');
            $table->foreignId('village_id')->constrained()->onDelete('cascade'); // Relasi ke villages
            $table->timestamps();
        });

        // Alamat
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->foreignId('postal_code_id')->constrained()->onDelete('cascade'); // Relasi ke postal_codes
            $table->string('street');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // Sesi
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Relasi ke users
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('postal_codes');
        Schema::dropIfExists('villages');
        Schema::dropIfExists('subdistricts');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};