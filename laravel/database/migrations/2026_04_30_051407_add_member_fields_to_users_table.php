<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->unique()->after('password');
            $table->string('register_number')->nullable()->unique()->after('nik');
            $table->string('kabupaten')->nullable()->after('register_number');
            $table->enum('member_status', ['pending', 'active', 'rejected'])->default('pending')->after('kabupaten');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'register_number', 'kabupaten', 'member_status']);
        });
    }
};
