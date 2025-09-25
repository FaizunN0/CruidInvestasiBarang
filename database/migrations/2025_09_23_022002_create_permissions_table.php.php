<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();   // create, update, delete
            $table->string('label');           // deskripsi (Create barang, dsb)
            $table->timestamps();
        });

        // seed default
        DB::table('permissions')->insert([
            ['name' => 'create', 'label' => 'Tambah Barang', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'update', 'label' => 'Edit Barang', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete', 'label' => 'Hapus Barang', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
