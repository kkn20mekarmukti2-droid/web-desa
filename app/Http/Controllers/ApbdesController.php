<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apbdes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            // Upload image directly to public/img/apbdes/ (following berita pattern)
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Create directory if not exists
            $targetDir = public_path('img/apbdes');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            // Move image to public/img/apbdes/
            $image->move($targetDir, $imageName);
            $imagePath = 'img/apbdes/' . $imageName;

            // Create APBDes record
            Apbdes::create([
                'title' => $request->title,
                'image_path' => $imagePath, // Store relative path from public/
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
                // Delete old image from public/img/apbdes/
                if ($apbdes->image_path) {
                    $oldImagePath = public_path($apbdes->image_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Upload new image directly to public/img/apbdes/
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Create directory if not exists
                $targetDir = public_path('img/apbdes');
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                
                // Move image to public/img/apbdes/
                $image->move($targetDir, $imageName);
                $data['image_path'] = 'img/apbdes/' . $imageName;
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
            
            // Delete image file from public/img/apbdes/
            if ($apbdes->image_path) {
                $imagePath = public_path($apbdes->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
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
