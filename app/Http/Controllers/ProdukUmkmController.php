<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukUmkm;

class ProdukUmkmController extends Controller
{
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
        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('umkm', 'public');
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
        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('umkm', 'public');
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
        $produk->delete();
        
        // Redirect berdasarkan context akses
        if (request()->is('admin/*')) {
            return redirect()->route('admin.produk-umkm.index')->with('success', 'Produk UMKM berhasil dihapus!');
        }
        
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil dihapus!');
    }
}
