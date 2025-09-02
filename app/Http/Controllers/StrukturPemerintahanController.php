<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturPemerintahan;
use Illuminate\Support\Str;

class StrukturPemerintahanController extends Controller
{
    // Public method untuk menampilkan struktur pemerintahan di frontend
    public function publicIndex()
    {
        $strukturList = StrukturPemerintahan::getAllOrdered();
        
        // Group by category untuk tampilan yang lebih terstruktur
        $grouped = [
            'kepala_desa' => $strukturList->where('kategori', 'kepala_desa')->first(),
            'sekretaris' => $strukturList->where('kategori', 'sekretaris')->first(),
            'kepala_urusan' => $strukturList->where('kategori', 'kepala_urusan'),
            'kepala_seksi' => $strukturList->where('kategori', 'kepala_seksi'),
            'kepala_dusun' => $strukturList->where('kategori', 'kepala_dusun')
        ];
        
        return view('pemerintahan-new', compact('grouped', 'strukturList'));
    }

    /**
     * Display a listing of the resource (Admin)
     */
    public function index()
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('pemerintahan')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $strukturList = StrukturPemerintahan::orderBy('urutan')->orderBy('nama')->paginate(12);
        return view('admin.struktur-pemerintahan.index', compact('strukturList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('pemerintahan')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        return view('admin.struktur-pemerintahan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('pemerintahan')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|in:kepala_desa,sekretaris,kepala_urusan,kepala_seksi,kepala_dusun',
            'urutan' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pendidikan' => 'nullable|string|max:100',
            'tugas_pokok' => 'nullable|string',
            'no_sk' => 'nullable|string|max:100',
            'tgl_sk' => 'nullable|date'
        ]);

        try {
            $data = $request->only(['nama', 'jabatan', 'kategori', 'urutan', 'pendidikan', 'tugas_pokok', 'no_sk', 'tgl_sk']);
            $data['is_active'] = $request->has('is_active');

            // Handle foto upload (following APBDes pattern)
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                
                // Create directory if not exists
                $targetDir = public_path('img/perangkat');
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                
                // Move foto to public/img/perangkat/
                $foto->move($targetDir, $fotoName);
                $data['foto'] = 'img/perangkat/' . $fotoName;
            }

            StrukturPemerintahan::create($data);

            return redirect()->route('admin.struktur-pemerintahan.index')
                           ->with('success', 'Struktur pemerintahan berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan struktur: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->check()) {
            return redirect()->route('pemerintahan')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $struktur = StrukturPemerintahan::findOrFail($id);
        
        // Get statistics for the show page
        $totalByCategory = StrukturPemerintahan::where('kategori', $struktur->kategori)->count();
        $totalActive = StrukturPemerintahan::where('is_active', true)->count();
        
        return view('admin.struktur-pemerintahan.show', compact('struktur', 'totalByCategory', 'totalActive'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Only allow admin access to edit
        if (!auth()->check()) {
            return redirect()->route('admin.struktur-pemerintahan.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $struktur = StrukturPemerintahan::findOrFail($id);
        return view('admin.struktur-pemerintahan.edit', compact('struktur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Only allow admin access to edit
        if (!auth()->check()) {
            return redirect()->route('admin.struktur-pemerintahan.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $struktur = StrukturPemerintahan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|in:kepala_desa,sekretaris,kepala_urusan,kepala_seksi,kepala_dusun',
            'urutan' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pendidikan' => 'nullable|string|max:100',
            'tugas_pokok' => 'nullable|string',
            'no_sk' => 'nullable|string|max:100',
            'tgl_sk' => 'nullable|date'
        ]);

        try {
            $data = $request->only(['nama', 'jabatan', 'kategori', 'urutan', 'pendidikan', 'tugas_pokok', 'no_sk', 'tgl_sk']);
            $data['is_active'] = $request->has('is_active');

            // Handle foto update
            if ($request->hasFile('foto')) {
                // Delete old foto
                if ($struktur->foto && file_exists(public_path($struktur->foto))) {
                    unlink(public_path($struktur->foto));
                }
                
                // Upload new foto
                $foto = $request->file('foto');
                $fotoName = time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                
                $targetDir = public_path('img/perangkat');
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                
                $foto->move($targetDir, $fotoName);
                $data['foto'] = 'img/perangkat/' . $fotoName;
            }

            $struktur->update($data);

            return redirect()->route('admin.struktur-pemerintahan.index')
                           ->with('success', 'Struktur pemerintahan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui struktur: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->check()) {
            return redirect()->route('pemerintahan')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        try {
            $struktur = StrukturPemerintahan::findOrFail($id);
            
            // Delete foto file
            if ($struktur->foto && file_exists(public_path($struktur->foto))) {
                unlink(public_path($struktur->foto));
            }
            
            $struktur->delete();

            return redirect()->route('admin.struktur-pemerintahan.index')
                           ->with('success', 'Struktur pemerintahan berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus struktur: ' . $e->getMessage());
        }
    }
}
