<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBarang = Barang::count();
        $jumlahUser = User::count();

        // aktivitas contoh — jika ada tabel log/aktivitas ganti sesuai implementasi
        $aktivitas = collect([
            (object)['deskripsi' => 'User Budi menambah barang', 'created_at' => now()->subMinutes(15)],
            (object)['deskripsi' => 'Admin Ani mengubah akun', 'created_at' => now()->subHours(3)],
        ]);

        // kategori berdasarkan lokasi
        $kategoriBarang = Barang::select('lokasi')->distinct()->pluck('lokasi')->toArray();
        $jumlahPerKategori = [];
        foreach ($kategoriBarang as $lok) {
            $jumlahPerKategori[] = Barang::where('lokasi', $lok)->count();
        }

        return view('dashboard', compact(
            'jumlahBarang','jumlahUser','aktivitas','kategoriBarang','jumlahPerKategori'
        ));
    }
}
