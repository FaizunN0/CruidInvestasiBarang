<?php

namespace App\Models;
//   jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'kode_barang',   
        'nama_barang',
        'jumlah',
        'satuan',
        'lokasi',
    ];
}
