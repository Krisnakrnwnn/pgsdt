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
        Schema::table('news', function (Blueprint $table) {
            // Drop the old enum column
            $table->dropColumn('category');
        });
        
        Schema::table('news', function (Blueprint $table) {
            // Add new enum column without 'warta', nullable
            $table->enum('category', ['pengumuman', 'kegiatan'])->nullable()->after('content');
        });
        
        // Update existing 'warta' records to null
        \DB::table('news')->where('category', 'warta')->update(['category' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category');
        });
        
        Schema::table('news', function (Blueprint $table) {
            $table->enum('category', ['warta', 'pengumuman', 'kegiatan'])->default('warta')->after('content');
        });
    }
};
