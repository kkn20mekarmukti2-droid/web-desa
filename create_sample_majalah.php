<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Majalah;
use App\Models\MajalahPage;
use Carbon\Carbon;

echo "Creating sample magazine data...\n";

// Create sample magazine
$majalah = Majalah::create([
    'judul' => 'Majalah Desa Edisi Perdana',
    'deskripsi' => 'Edisi perdana majalah desa yang berisi informasi terkini tentang perkembangan desa, kegiatan masyarakat, dan berbagai program pembangunan yang sedang berjalan.',
    'cover_image' => 'majalah/sample-cover.jpg',
    'tanggal_terbit' => Carbon::now()->subDays(7),
    'is_active' => true
]);

echo "Magazine created with ID: {$majalah->id}\n";

// Create sample pages
$samplePages = [
    ['title' => 'Cover Depan', 'description' => 'Cover majalah edisi perdana'],
    ['title' => 'Kata Pengantar', 'description' => 'Sambutan dari Kepala Desa'],
    ['title' => 'Berita Utama', 'description' => 'Program pembangunan infrastruktur desa'],
    ['title' => 'Kegiatan Masyarakat', 'description' => 'Gotong royong pembersihan lingkungan'],
    ['title' => 'UMKM Desa', 'description' => 'Profil pengusaha UMKM sukses di desa'],
    ['title' => 'Pendidikan', 'description' => 'Prestasi siswa sekolah dasar desa'],
    ['title' => 'Kesehatan', 'description' => 'Program vaksinasi dan posyandu'],
    ['title' => 'Pariwisata', 'description' => 'Destinasi wisata alam di sekitar desa'],
    ['title' => 'Teknologi', 'description' => 'Digitalisasi pelayanan desa'],
    ['title' => 'Cover Belakang', 'description' => 'Penutup dan kontak informasi']
];

foreach ($samplePages as $index => $pageData) {
    MajalahPage::create([
        'majalah_id' => $majalah->id,
        'page_number' => $index + 1,
        'title' => $pageData['title'],
        'description' => $pageData['description'],
        'image_path' => "majalah/pages/{$majalah->id}/page-" . ($index + 1) . ".jpg"
    ]);
    
    echo "Created page " . ($index + 1) . ": {$pageData['title']}\n";
}

echo "\nSample magazine data created successfully!\n";
echo "Magazine: {$majalah->judul}\n";
echo "Total pages: " . $majalah->pages()->count() . "\n";
echo "You can now view it at: http://localhost:8000/majalah-desa\n";
