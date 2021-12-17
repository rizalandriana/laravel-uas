<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\KembaliController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('index');
})->name('dashboard');

Route::get('/member/category', [KategoriController::class, 'index']);
// Route::get('/member/category/recycle', [KategoriController::class, 'recycle']);
Route::get('/member/category/tambah', [KategoriController::class, 'tambah']);
Route::post('/member/category/store', [KategoriController::class, 'store']);
Route::get('/member/category/edit/{id}', [KategoriController::class, 'edit']);
Route::put('/member/category/update/{id}', [KategoriController::class, 'update']);
Route::get('/member/category/hapus/{id}', [KategoriController::class, 'delete']);
Route::get('/member/category/hapusAll', [KategoriController::class, 'deleteAll']);
Route::get('/member/category/restore/{id}', [KategoriController::class, 'restore']);
Route::get('/member/category/restoreAll', [KategoriController::class, 'restoreAll']);
Route::get('/member/category/hapuspermanen/{id}', [KategoriController::class, 'hapuspermanen']);
Route::get('/member/category/hapuspermanenAll', [KategoriController::class, 'hapuspermanenAll']);

Route::get('/member', [MemberController::class, 'index']);
Route::get('/member/recycle', [MemberController::class, 'recycle']);
Route::get('/member/tambah', [MemberController::class, 'tambah']);
Route::post('/member/store', [MemberController::class, 'store']);
Route::get('/member/edit/{id}', [MemberController::class, 'edit']);
Route::put('/member/update/{id}', [MemberController::class, 'update']);
Route::get('/member/hapus/{id}', [MemberController::class, 'delete']);
Route::get('/member/hapusAll', [MemberController::class, 'deleteAll']);
Route::get('/member/restore/{id}', [MemberController::class, 'restore']);
Route::get('/member/restoreAll', [MemberController::class, 'restoreAll']);
Route::get('/member/hapuspermanen/{id}', [MemberController::class, 'hapuspermanen']);
Route::get('/member/hapuspermanenAll', [MemberController::class, 'hapuspermanenAll']);

Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/recycle', [BukuController::class, 'recycle']);
Route::get('/buku/tambah', [BukuController::class, 'tambah']);
Route::post('/buku/store', [BukuController::class, 'store']);
Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
Route::put('/buku/update/{id}', [BukuController::class, 'update']);
Route::get('/buku/hapus/{id}', [BukuController::class, 'delete']);
Route::get('/buku/hapusAll', [BukuController::class, 'deleteAll']);
Route::get('/buku/restore/{id}', [BukuController::class, 'restore']);
Route::get('/buku/restoreAll', [BukuController::class, 'restoreAll']);
Route::get('/buku/hapuspermanen/{id}', [BukuController::class, 'hapuspermanen']);
Route::get('/buku/hapuspermanenAll', [BukuController::class, 'hapuspermanenAll']);
Route::post('/buku/storecart', [BukuController::class, 'storecart']);

Route::get('/countcart', [PinjamController::class, 'countcart']);
Route::get('/pinjam', [PinjamController::class, 'index']);
Route::get('/pinjam/member', [PinjamController::class, 'member']);
Route::get('/pinjam/buku', [PinjamController::class, 'buku']);
Route::post('/pinjam/storecart', [PinjamController::class, 'storecart']);
Route::get('/pinjam/loadcart', [PinjamController::class, 'loadcart']);
Route::put('/pinjam/updatecart/{id}', [PinjamController::class, 'updatecart']);
Route::get('/pinjam/deletecart/{id}', [PinjamController::class, 'deletecart']);
Route::get('/pinjam/deletecartall', [PinjamController::class, 'deletecartall']);
Route::post('/pinjam/storepinjam', [PinjamController::class, 'storepinjam']);
Route::post('/pinjam/storepinjamdetails', [PinjamController::class, 'storepinjamdetails']);
Route::get('/pinjam/report', [PinjamController::class, 'report']);
Route::get('/pinjam/reportdetail/{id}', [PinjamController::class, 'reportdetail']);
Route::get('/pinjam/cetakpdf', [PinjamController::class, 'cetakpdf']);

Route::get('/kembali', [KembaliController::class, 'index']);
Route::get('/kembali/pinjamdetail/{id}', [KembaliController::class, 'pinjamdetail']);
Route::get('/kembali/accept/{id}', [KembaliController::class, 'accept']);
Route::post('/kembali/store', [KembaliController::class, 'store']);
Route::get('/kas/report', [KembaliController::class, 'kas']);
Route::get('/kas/cetakpdf', [KembaliController::class, 'cetakpdf']);

Route::get('cropper', [MemberController::class, 'crop']);
Route::post('cropper/upload', [MemberController::class, 'cropupload']);