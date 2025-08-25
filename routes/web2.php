<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\galleryController;
use App\Http\Controllers\NotificationTokenController;

Route::get('/', [homeController::class, 'index'])->name('home');
Route::get('about', [homeController::class, 'about'])->name('about');
route::get('pemerintahan', [homeController::class, 'pemerintahan'])->name('pemerintahan');
route::get('potensi-desa', [homeController::class, 'potensidesa'])->name('potensidesa');
route::get('galeri-desa', [galleryController::class, 'galeri'])->name('galeri');
route::get('kontak-desa', [homeController::class, 'kontak'])->name('kontak');
route::post('kontak-desa', [homeController::class, 'sendkontak'])->name('send.message');
Route::get('data/penduduk', [dataController::class, 'penduduk'])->name('data.penduduk');
Route::get('data/KK', [dataController::class, 'kk'])->name('data.kk');
Route::get('data/pendidikan', [dataController::class, 'pendidikan'])->name('data.pendidikan');
Route::get('data/kesehatan', [dataController::class, 'kesehatan'])->name('data.kesehatan');
Route::get('data/siswa', [dataController::class, 'siswa'])->name('data.siswa');
Route::get('data/profesi', [dataController::class, 'profesi'])->name('data.profesi');
Route::get('data/klub', [dataController::class, 'klub'])->name('data.klub');
Route::get('data/kesenian', [dataController::class, 'kesenian'])->name('data.kesenian');
Route::get('data/sumber-air', [dataController::class, 'sumberair'])->name('data.sumberair');
Route::get('/Berita/{tanggal}/{judul}', [homeController::class, 'tampilberita'])->name('detailartikel');
Route::get('/Berita', [homeController::class, 'berita'])->name('berita');
Route::get('RW/{rw}', [dataController::class, 'rw'])->name('data.rw');

Route::get('/get-data/{type}', [dataController::class, 'getChartData'])->name('getData');
Route::post('/save-token', [NotificationTokenController::class, 'saveToken'])->name('save.token');

Route::get('admin', [authController::class, 'formlogin'])->name('formlogin');
Route::get('login', function () {
    return redirect()->route('formlogin');
});
Route::post('login', [authController::class, 'login'])->name('login');
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('send-notif', [NotificationTokenController::class, 'sendPushNotification'])->name('notif.send');
    Route::get('gallery', [galleryController::class, 'index'])->name('gallery.index');
    Route::post('gallery/add', [galleryController::class, 'store'])->name('gallery.store');
    Route::get('gallery/destroy/{id}', [galleryController::class, 'destroy'])->name('gallery.delete');
    Route::get('logout', function () {
        Auth::logout();
        return redirect()->route('home');
    })->name('logout');
    Route::get('manage-akun', [authController::class, 'index'])->name('akun.manage');
    Route::get('tambah-akun', [authController::class, 'create'])->name('akun.create');
    Route::post('akun/update-role/{user}', [authController::class, 'updateRole'])->name('akun.roleupdate');
    Route::post('akun/reset-password/{user}', [authController::class, 'resetPassword'])->name('akun.resetpass');
    Route::post('akun/new-akun', [authController::class, 'store'])->name('akun.new');

    Route::get('rtrw', [adminController::class, 'rtrw'])->name('rtrw');
    Route::get('rw/add', [adminController::class, 'rwadd'])->name('rw.create');
    Route::post('rw/store', [adminController::class, 'rwstore'])->name('rw.store');
    Route::delete('rw/delete/{id}', [adminController::class, 'rwdelete'])->name('rw.delete');
    Route::get('rt/add/{rw_id}', [adminController::class, 'rtadd'])->name('rt.create');
    Route::post('rt/store', [adminController::class, 'rtstore'])->name('rt.store');
    Route::delete('rt/delete/{id}', [adminController::class, 'rtdelete'])->name('rt.delete');

    Route::get('preview/{id}', [adminController::class, 'preview'])->name('preview');
    Route::get('dashboard', [adminController::class, 'dashboard'])->name('dashboard');
    Route::post('/kategori/add', [adminController::class, 'tambahkategori'])->name('kategori.store');
    Route::delete('/kategori/delete/{id}', [adminController::class, 'deletekategori'])->name('kategori.delete');

    Route::post('/updateprofile', [adminController::class, 'upprofile'])->name('uploadprofile');
    Route::post('img/upload', [adminController::class, 'uploadimg'])->name('img.upload');
    Route::post('/ubah/status', [adminController::class, 'ubahstatus'])->name('ubahstatus');
    Route::get('content/add', [adminController::class, 'addartikel'])->name('addartikel');
    Route::post('content/store', [adminController::class, 'storeartikel'])->name('artikel.store');
    Route::delete('/artikel/{id}/delete', [adminController::class, 'deleteartikel'])->name('artikel.delete');
    Route::get('/artikel/{id}/edit', [adminController::class, 'editartikel'])->name('artikel.edit');
    Route::post('/artikel/{id}/update', [adminController::class, 'updateartikel'])->name('artikel.update');
});

// Route::fallback(function () {return view('404');});

Route::get('/panel', function () {
    return redirect()->away('https://mekarmukti.id:2083');
});


Route::get('/cpanel', function () {
    abort(404);
});
