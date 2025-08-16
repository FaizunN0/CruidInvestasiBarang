<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

//   jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', fn() => redirect()->route('barangs.index'));
Route::resource('barangs', BarangController::class);
