<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\artikelModel;
use App\Models\kategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    public function index()
    {
        $artikel = artikelModel::orderByDesc('id')->where('status', true)->take(8)->get();
        return view("index", compact("artikel"));
    }

    public function berita()
    {
        $search = request("search");
        $kategori = request("kategori");

        $artikelQuery = artikelModel::with('getKategori', 'creator')->where('status', true);

        $artikelQuery->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%')
                      ->orWhere('header', 'like', '%' . $search . '%');
            });
        });

        $artikelQuery->when($kategori, function ($query, $kategori) {
            $kat = kategoriModel::where('judul', $kategori)->first();
            $query->where('kategori', $kat->id);
        });

        $artikelQuery->orderByDesc('id');
        $artikel = $artikelQuery->paginate(10)->appends([
            'search' => $search,
            'kategori' => $kategori
        ]);

        $rekomendasi = artikelModel::where('status', true)->inRandomOrder()->take(6)->get();
        $listkategori = kategoriModel::withCount('artikel')->get();
        return view("artikel", compact("artikel", "rekomendasi", "listkategori"));
    }

    public function about()
    {
        return view("about");
    }

    public function tampilberita($tanggal, $judul)
    {
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $judul = Str::slug($judul, ' ');

        $artikel = artikelModel::with('creator')
            ->whereRaw("TRIM(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(judul, '|', ''), '-', ''), '&', ''), '  ', ' '),'(',''),')','')) = ?", [$judul])
            ->where('created_at', 'like', '%' . $tanggal . '%')
            ->where('status', true)
            ->first();

        if (!$artikel) {
            return redirect()->intended('/');
        }

        $rekomendasi = artikelModel::with('getKategori', 'creator')
            ->where('status', true)
            ->whereNotIn('id', [$artikel->id])
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('detailartikel', [
            'artikel' => $artikel,
            'rekomendasi' => $rekomendasi
        ]);
    }

    public function sejarah()
    {
        return view("sejarah");
    }

    public function visi()
    {
        return view("visi");
    }

    public function pemerintahan()
    {
        // Use the new controller method
        $controller = new \App\Http\Controllers\StrukturPemerintahanController();
        return $controller->publicIndex();
    }

    public function potensidesa()
    {
        $kategori = artikelModel::where('kategori', 0)->get();
        return view("potensidesa", compact("kategori"));
    }

    public function kontak()
    {
        return view("kontak");
    }

    public function sendkontak(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // proses kirim email bisa ditambahkan di sini
    }

    public function pengaduan()
    {
        return view("pengaduan");
    }

    public function sendPengaduan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'isi_pengaduan' => 'required|string',
        ]);

        DB::table('pengaduan')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'isi_pengaduan' => $request->isi_pengaduan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
    }
}
