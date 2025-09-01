<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukUmkm;
use Illuminate\Support\Str;

class ProdukUmkmController extends Controller
{
    /**
     * Delete physical image file if exists (supports both storage disk path and direct public path)
     */
    private function deleteImageIfExists(?string $path): void
    {
        if (!$path) return;

        // Possible locations:
        // 1. Stored via old logic: storage/app/public/umkm/filename (public/storage/umkm/filename accessible)
        // 2. New logic (adapted to Apbdes style): public/img/umkm/filename (stored as img/umkm/filename)
        $candidates = [];
        // If path already includes 'img/umkm/' treat it as relative under public
        if (str_starts_with($path, 'img/umkm/')) {
            $candidates[] = public_path($path);
        }
        // If path starts with 'umkm/' (old disk relative), map to public/storage/umkm
        if (str_starts_with($path, 'umkm/')) {
            $candidates[] = public_path('storage/' . $path);
        }
        // Also if full path accidentally stored
        if (file_exists($path)) {
            $candidates[] = $path;
        }

        foreach (array_unique($candidates) as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }
    // Tampilkan semua produk UMKM (untuk publik)
    public function index()
    {
        $produkList = ProdukUmkm::paginate(9);
        
        // Jika user adalah admin dan akses dari admin panel
        if (auth()->check() && request()->is('admin/*')) {
            return view('admin.produk-umkm.index', compact('produkList'));
        }
        
        // Untuk akses publik
        return view('produk-umkm', compact('produkList'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        // Only allow admin access to create
        if (!auth()->check()) {
            return redirect()->route('potensidesa')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        return view('admin.produk-umkm.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        // Only allow admin access to store
        if (!auth()->check()) {
            return redirect()->route('potensidesa')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nomor_telepon' => 'required',
        ]);
        $data = $request->only(['nama_produk','deskripsi','nomor_telepon']);

        // Handle image (adapt Apbdes style: store under public/img/umkm)
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $targetDir = public_path('img/umkm');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $image->move($targetDir, $imageName);
            $data['gambar'] = 'img/umkm/' . $imageName; // store relative path
        }

        ProdukUmkm::create($data);
        
        // Redirect berdasarkan context akses
        if (request()->is('admin/*')) {
            return redirect()->route('admin.produk-umkm.index')->with('success', 'Produk UMKM berhasil ditambahkan!');
        }
        
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil ditambahkan!');
    }

    // Tampilkan detail produk
    public function show($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        
        // Jika user adalah admin dan akses dari admin panel
        if (auth()->check() && request()->is('admin/*')) {
            return view('admin.produk-umkm.show', compact('produk'));
        }
        
        // Untuk akses publik
        return view('produk-umkm-show', compact('produk'));
    }

    // Tampilkan form edit produk
    public function edit($id)
    {
        // Only allow admin access to edit
        if (!auth()->check()) {
            return redirect()->route('potensidesa')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        $produk = ProdukUmkm::findOrFail($id);
        return view('admin.produk-umkm.edit', compact('produk'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        // Only allow admin access to update
        if (!auth()->check()) {
            return redirect()->route('potensidesa')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nomor_telepon' => 'required',
        ]);
        $produk = ProdukUmkm::findOrFail($id);
        $data = $request->only(['nama_produk','deskripsi','nomor_telepon']);
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            $this->deleteImageIfExists($produk->gambar);

            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $targetDir = public_path('img/umkm');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $image->move($targetDir, $imageName);
            $data['gambar'] = 'img/umkm/' . $imageName;
        }
        $produk->update($data);
        
        // Redirect berdasarkan context akses
        if (request()->is('admin/*')) {
            return redirect()->route('admin.produk-umkm.index')->with('success', 'Produk UMKM berhasil diupdate!');
        }
        
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil diupdate!');
    }

    // Hapus produk
    public function destroy($id)
    {
        // Only allow admin access to destroy
        if (!auth()->check()) {
            return redirect()->route('potensidesa')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
    $produk = ProdukUmkm::findOrFail($id);
    // Delete associated image file
    $this->deleteImageIfExists($produk->gambar);
    $produk->delete();
        
        // Redirect berdasarkan context akses
        if (request()->is('admin/*')) {
            return redirect()->route('admin.produk-umkm.index')->with('success', 'Produk UMKM berhasil dihapus!');
        }
        
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil dihapus!');
    }
}
