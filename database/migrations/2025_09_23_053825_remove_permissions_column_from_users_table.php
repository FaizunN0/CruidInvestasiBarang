<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // cek apakah kolom lama 'permissions' masih ada, kalau ada drop
        if (Schema::hasColumn('users', 'permissions')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('permissions');
            });
        }
    }

    public function down(): void
    {
        // kalau rollback, balikin lagi kolom lama (opsional, json nullable)
        Schema::table('users', function (Blueprint $table) {
            $table->json('permissions')->nullable();
        });
    }
};
