<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukUmkm;

class ProdukUmkmController extends Controller
{
    // Tampilkan semua produk UMKM
    public function index()
    {
        $produkList = ProdukUmkm::paginate(9);
        return view('produk-umkm', compact('produkList'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        return view('produk-umkm-create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
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
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil ditambahkan!');
    }

    // Tampilkan detail produk
    public function show($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        return view('produk-umkm-show', compact('produk'));
    }

    // Tampilkan form edit produk
    public function edit($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        return view('produk-umkm-edit', compact('produk'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
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
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil diupdate!');
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk-umkm.index')->with('success', 'Produk UMKM berhasil dihapus!');
    }
}
