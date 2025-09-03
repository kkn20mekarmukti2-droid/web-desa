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

    public function pengaduan()
    {
        return view("pengaduan");
    }

    public function sendPengaduan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'kategori' => 'required|string|in:infrastruktur,pelayanan,lingkungan,sosial,ekonomi,keamanan,lainnya',
            'isi_pengaduan' => 'required|string|min:20|max:500',
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 20 karakter',
            'kategori.required' => 'Kategori pengaduan harus dipilih',
            'kategori.in' => 'Kategori yang dipilih tidak valid',
            'isi_pengaduan.required' => 'Isi pengaduan harus diisi',
            'isi_pengaduan.min' => 'Isi pengaduan minimal 20 karakter',
            'isi_pengaduan.max' => 'Isi pengaduan maksimal 500 karakter',
        ]);

        // Periksa apakah tabel pengaduan ada, jika tidak buat terlebih dahulu
        try {
            DB::table('pengaduan')->insert([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'kategori' => $request->kategori,
                'isi_pengaduan' => $request->isi_pengaduan,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Pengaduan Anda telah berhasil dikirim! Kami akan menindaklanjuti dalam waktu maksimal 3x24 jam kerja.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi atau hubungi administrator.')->withInput();
        }
    }
}
