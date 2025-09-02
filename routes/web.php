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
Route::get('/potensi-desa', [\App\Http\Controllers\ProdukUmkmController::class, 'index'])->name('potensidesa');
Route::get('/visi', [homeController::class, 'visi'])->name('visi');
Route::get('/sejarah', [homeController::class, 'sejarah'])->name('sejarah');

// Produk UMKM
Route::resource('produk-umkm', App\Http\Controllers\ProdukUmkmController::class);

// Galeri
Route::get('/galeri-desa', [galleryController::class, 'galeri'])->name('galeri');

// Kontak
Route::get('/kontak-desa', [homeController::class, 'kontak'])->name('kontak');
Route::post('/kontak-desa', [homeController::class, 'sendkontak'])->name('send.message');

// Berita
Route::get('/berita', [homeController::class, 'berita'])->name('berita');
Route::get('/berita/{tanggal}/{judul}', [homeController::class, 'tampilberita'])->name('detailartikel');

// Pengaduan
Route::post('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'store'])->name('pengaduan.store');

// Transparansi Anggaran APBDes
Route::get('/transparansi-anggaran', [\App\Http\Controllers\ApbdesController::class, 'transparansi'])->name('transparansi.anggaran');

// Data Desa
Route::prefix('data')->group(function () {
    Route::get('/penduduk', [dataController::class, 'penduduk'])->name('data.penduduk');
    Route::get('/statistik', function() { return view('data-statistik-baru'); })->name('data.statistik');
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
    // Dashboard - Redirect to Modern
    Route::get('/dashboard', function() {
        return redirect()->route('dashboard.modern');
    })->name('dashboard');
    
    // Modern Admin Dashboard
    Route::get('/dashboard-modern', function() {
        $data = [
            'artikel' => \App\Models\artikelModel::all(),
            'gallery' => \App\Models\galleryModel::all(),
            'users' => \App\Models\User::all(),
            'kategori' => \App\Models\kategoriModel::all(),
        ];
        return view('admin.dashboard-modern', $data);
    })->name('dashboard.modern');
    
    // Content Management - Redirect to Modern
    Route::get('/content/manage', function() {
        return redirect()->route('content.manage.modern');
    })->name('content.manage');
    Route::get('/content/manage-modern', function() {
        $data = [
            'artikel' => \App\Models\artikelModel::with('getKategori')->get(),
            'kategori' => \App\Models\kategoriModel::all(),
        ];
        return view('admin.content.manage-modern', $data);
    })->name('content.manage.modern');
    
    Route::get('/preview/{id}', [adminController::class, 'preview'])->name('preview');

    // Kelola Notifikasi
    Route::post('/send-notif', [NotificationTokenController::class, 'sendPushNotification'])->name('notif.send');

    // Galeri - Redirect to Modern
    Route::get('/gallery', function() {
        return redirect()->route('gallery.manage.modern');
    })->name('gallery.index');
    Route::get('/gallery-modern', function() {
        $data = [
            'gallery' => \App\Models\galleryModel::orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.gallery.manage-modern', $data);
    })->name('gallery.manage.modern');
    Route::post('/gallery/add', [galleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/destroy/{id}', [galleryController::class, 'destroy'])->name('gallery.delete');
    Route::delete('/gallery/bulk-delete', [galleryController::class, 'bulkDestroy'])->name('gallery.bulk-delete');

    // Pengaduan Management
    Route::get('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'index'])->name('admin.pengaduan.index');

    // APBDes Management
    Route::prefix('apbdes')->name('apbdes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ApbdesController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ApbdesController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ApbdesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\ApbdesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\ApbdesController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\ApbdesController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [\App\Http\Controllers\ApbdesController::class, 'toggleActive'])->name('toggle');
    });
    
    // Alias admin routes with admin prefix
    Route::prefix('apbdes')->name('admin.apbdes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ApbdesController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ApbdesController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ApbdesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\ApbdesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\ApbdesController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\ApbdesController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [\App\Http\Controllers\ApbdesController::class, 'toggleActive'])->name('toggle');
    });

    // Struktur Pemerintahan Management
    Route::prefix('struktur-pemerintahan')->name('admin.struktur-pemerintahan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\StrukturPemerintahanController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\StrukturPemerintahanController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\StrukturPemerintahanController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\StrukturPemerintahanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\StrukturPemerintahanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\StrukturPemerintahanController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\StrukturPemerintahanController::class, 'destroy'])->name('destroy');
    });

    // Produk UMKM Admin Management
    Route::prefix('produk-umkm')->name('admin.produk-umkm.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ProdukUmkmController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ProdukUmkmController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ProdukUmkmController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\ProdukUmkmController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\ProdukUmkmController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\ProdukUmkmController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\ProdukUmkmController::class, 'destroy'])->name('destroy');
    });

    // Hero Images Admin Management
    Route::prefix('hero-images')->name('admin.hero-images.')->group(function () {
        Route::get('/', [\App\Http\Controllers\HeroImageController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\HeroImageController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\HeroImageController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\HeroImageController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\HeroImageController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\HeroImageController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\HeroImageController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Akun - Redirect to Modern
    Route::get('/manage-akun', function() {
        return redirect()->route('users.manage.modern');
    })->name('akun.manage');
    Route::get('/users-modern', function() {
        $data = [
            'users' => \App\Models\User::orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.users.manage-modern', $data);
    })->name('users.manage.modern');
    
    // User Management Routes
    Route::post('/users/store', [authController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [authController::class, 'show'])->name('users.show');
    Route::patch('/users/{id}/toggle-status', [authController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/reset-password', [authController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{id}', [authController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/bulk-activate', [authController::class, 'bulkActivate'])->name('users.bulk-activate');
    Route::post('/users/bulk-deactivate', [authController::class, 'bulkDeactivate'])->name('users.bulk-deactivate');
    Route::post('/users/bulk-delete', [authController::class, 'bulkDelete'])->name('users.bulk-delete');
    Route::get('/users/export', [authController::class, 'export'])->name('users.export');
    
    // RT/RW Management Routes
    Route::get('/rtrw/manage', [\App\Http\Controllers\rtRwController::class, 'manageModern'])->name('rtrw.manage.modern');
    Route::post('/rw/store', [\App\Http\Controllers\rtRwController::class, 'storeRW'])->name('rw.store');
    Route::put('/rw/update/{id}', [\App\Http\Controllers\rtRwController::class, 'updateRW'])->name('rw.update');
    Route::delete('/rw/delete/{id}', [\App\Http\Controllers\rtRwController::class, 'deleteRW'])->name('rw.delete');
    Route::post('/rt/store', [\App\Http\Controllers\rtRwController::class, 'storeRT'])->name('rt.store');
    Route::put('/rt/update/{id}', [\App\Http\Controllers\rtRwController::class, 'updateRT'])->name('rt.update');
    Route::delete('/rt/delete/{id}', [\App\Http\Controllers\rtRwController::class, 'deleteRT'])->name('rt.delete');
    
    Route::get('/tambah-akun', [authController::class, 'create'])->name('akun.create');
    Route::post('/akun/update-role/{user}', [authController::class, 'updateRole'])->name('akun.roleupdate');
    Route::post('/akun/reset-password/{user}', [authController::class, 'resetPassword'])->name('akun.resetpass');
    Route::post('/akun/new-akun', [authController::class, 'store'])->name('akun.new');
    Route::delete('/users/{user}', [authController::class, 'destroy'])->name('users.destroy');

    // Artikel & Konten
    Route::get('/content/add', [adminController::class, 'addartikel'])->name('addartikel');
    Route::post('/content/store', [adminController::class, 'storeartikel'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [adminController::class, 'editartikel'])->name('artikel.edit');
    Route::post('/artikel/{id}/update', [adminController::class, 'updateartikel'])->name('artikel.update');
    Route::delete('/artikel/{id}/delete', [adminController::class, 'deleteartikel'])->name('artikel.delete');

    // Kategori
    Route::post('/kategori/add', [adminController::class, 'tambahkategori'])->name('kategori.store');
    Route::delete('/kategori/delete/{id}', [adminController::class, 'deletekategori'])->name('kategori.delete');

    // Data Statistik CRUD
    Route::resource('statistik', App\Http\Controllers\StatistikController::class)->names([
        'index' => 'admin.statistik.index',
        'create' => 'admin.statistik.create', 
        'store' => 'admin.statistik.store',
        'show' => 'admin.statistik.show',
        'edit' => 'admin.statistik.edit',
        'update' => 'admin.statistik.update',
        'destroy' => 'admin.statistik.destroy'
    ]);

    // Gambar & Profil
    Route::post('/img/upload', [adminController::class, 'uploadimg'])->name('img.upload');
    Route::post('/updateprofile', [adminController::class, 'upprofile'])->name('uploadprofile');

    // Ubah Status Artikel
    Route::post('/ubah/status', [adminController::class, 'ubahstatus'])->name('ubahstatus');

    // Village Data Population
    Route::get('/village/populate-real-data', [adminController::class, 'populateRealData'])->name('admin.village:populate-real-data');
    
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


