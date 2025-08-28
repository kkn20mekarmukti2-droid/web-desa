<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\artikelModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== DEBUG ARTIKEL ===" . PHP_EOL;
echo "Total artikel di database: " . artikelModel::count() . PHP_EOL;
echo "Artikel dengan status 1 (published): " . artikelModel::where('status', 1)->count() . PHP_EOL;
echo "Artikel dengan status 0 (draft): " . artikelModel::where('status', 0)->count() . PHP_EOL;

echo PHP_EOL . "Detail semua artikel:" . PHP_EOL;
$artikels = artikelModel::with('getKategori')->get();
foreach($artikels as $artikel) {
    echo "ID: " . $artikel->id . 
         " | Judul: " . substr($artikel->judul, 0, 30) . "..." .
         " | Status: " . ($artikel->status ? 'Published' : 'Draft') . 
         " | Created by: " . $artikel->created_by .
         " | Kategori: " . ($artikel->getKategori ? $artikel->getKategori->judul : 'No category') . 
         PHP_EOL;
}

echo PHP_EOL . "=== USERS ===" . PHP_EOL;
$users = User::all();
foreach($users as $user) {
    echo "ID: " . $user->id . " | Name: " . $user->name . " | Role: " . $user->role . PHP_EOL;
}
?>
