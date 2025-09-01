<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apbdes;
use Illuminate\Support\Facades\Storage;

class ApbdesController extends Controller
{
    // Frontend - Halaman Transparansi Anggaran
    public function transparansi()
    {
        $apbdes = Apbdes::getActive();
        return view('transparansi-anggaran', compact('apbdes'));
    }

    // Admin - List APBDes
    public function index()
    {
        $apbdes = Apbdes::orderBy('tahun', 'desc')->get();
        return view('admin.apbdes.index', compact('apbdes'));
    }

    // Admin - Form Create
    public function create()
    {
        return view('admin.apbdes.create');
    }

    // Admin - Store APBDes
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
            'description' => 'nullable|string|max:1000'
        ], [
            'title.required' => 'Judul APBDes harus diisi',
            'tahun.required' => 'Tahun harus diisi',
            'tahun.min' => 'Tahun minimal 2020',
            'tahun.max' => 'Tahun maksimal 2030',
            'image.required' => 'Gambar APBDes harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 5MB'
        ]);

        try {
            // Upload image
            $imagePath = $request->file('image')->store('apbdes', 'public');

            // Create APBDes record
            Apbdes::create([
                'title' => $request->title,
                'image_path' => $imagePath,
                'description' => $request->description,
                'tahun' => $request->tahun,
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.apbdes.index')
                           ->with('success', 'APBDes berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan APBDes: ' . $e->getMessage());
        }
    }

    // Admin - Form Edit
    public function edit($id)
    {
        $apbdes = Apbdes::findOrFail($id);
        return view('admin.apbdes.edit', compact('apbdes'));
    }

    // Admin - Update APBDes
    public function update(Request $request, $id)
    {
        $apbdes = Apbdes::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'description' => 'nullable|string|max:1000'
        ]);

        try {
            $data = $request->only(['title', 'description', 'tahun']);
            $data['is_active'] = $request->has('is_active');

            // Handle image update
            if ($request->hasFile('image')) {
                // Delete old image
                if ($apbdes->image_path) {
                    Storage::disk('public')->delete($apbdes->image_path);
                }
                
                // Upload new image
                $data['image_path'] = $request->file('image')->store('apbdes', 'public');
            }

            $apbdes->update($data);

            return redirect()->route('admin.apbdes.index')
                           ->with('success', 'APBDes berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui APBDes: ' . $e->getMessage());
        }
    }

    // Admin - Delete APBDes
    public function destroy($id)
    {
        try {
            $apbdes = Apbdes::findOrFail($id);
            
            // Delete image file
            if ($apbdes->image_path) {
                Storage::disk('public')->delete($apbdes->image_path);
            }
            
            $apbdes->delete();

            return redirect()->route('admin.apbdes.index')
                           ->with('success', 'APBDes berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus APBDes: ' . $e->getMessage());
        }
    }

    // Admin - Toggle Active Status
    public function toggleActive($id)
    {
        try {
            $apbdes = Apbdes::findOrFail($id);
            $apbdes->is_active = !$apbdes->is_active;
            $apbdes->save();

            $status = $apbdes->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->back()->with('success', "APBDes berhasil {$status}!");

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
