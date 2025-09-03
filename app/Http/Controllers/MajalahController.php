<?php

namespace App\Http\Controllers;

use App\Models\Majalah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajalahController extends Controller
{
    public function index()
    {
        $majalah = Majalah::orderBy('created_at', 'desc')->get();
        return view('admin.majalah.manage-modern', compact('majalah'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'url' => 'required|file|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $majalah = new Majalah();
        $majalah->judul = $request->input('judul');
        $majalah->deskripsi = 'Cover majalah digital desa';
        $majalah->is_active = true;
        $majalah->tanggal_terbit = now();
        
        if ($request->hasFile('url')) {
            $originName = $request->file('url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('url')->getClientOriginalExtension();
            $nama = $fileName . '_' . time() . '.' . $extension;
            
            // Try multiple directories for better compatibility
            $uploaded = false;
            $directories = ['majalah', 'galeri'];
            
            foreach ($directories as $dir) {
                try {
                    if (!file_exists(public_path($dir))) {
                        mkdir(public_path($dir), 0755, true);
                    }
                    
                    if ($request->file('url')->move(public_path($dir), $nama)) {
                        $majalah->cover_image = $dir . '/' . $nama;
                        $uploaded = true;
                        break;
                    }
                } catch (Exception $e) {
                    continue;
                }
            }
            
            if (!$uploaded) {
                return redirect()->back()->with('error', 'Gagal mengupload file.');
            }
        }
        
        $majalah->save();

        return redirect()->route('majalah.index')->with('success', 'Majalah berhasil ditambahkan.');
    }
    
    public function publicIndex()
    {
        $majalah = Majalah::where('is_active', true)->orderBy('created_at', 'desc')->get();
        return view("public.majalah", compact('majalah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $majalah = Majalah::findOrFail($id);
        
        // Update basic fields
        $majalah->judul = $request->input('judul');

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($majalah->cover_image) {
                $oldImagePath = public_path($majalah->cover_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $originName = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $nama = $fileName . '_' . time() . '.' . $extension;
            
            // Try multiple directories for better compatibility
            $uploaded = false;
            $directories = ['majalah', 'galeri'];
            
            foreach ($directories as $dir) {
                try {
                    if (!file_exists(public_path($dir))) {
                        mkdir(public_path($dir), 0755, true);
                    }
                    
                    if ($request->file('image')->move(public_path($dir), $nama)) {
                        $majalah->cover_image = $dir . '/' . $nama;
                        $uploaded = true;
                        break;
                    }
                } catch (Exception $e) {
                    continue;
                }
            }
            
            if (!$uploaded) {
                return redirect()->back()->with('error', 'Gagal mengupload file.');
            }
        }

        $majalah->save();

        return redirect()->route('majalah.index')->with('success', 'Majalah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $majalah = Majalah::findOrFail($id);
        
        // Delete physical file if exists
        if ($majalah->cover_image) {
            $imagePath = public_path($majalah->cover_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $majalah->delete();

        return redirect()->route('majalah.index')->with('success', 'Majalah berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        $deleted = 0;
        
        foreach ($ids as $id) {
            $majalah = Majalah::find($id);
            if ($majalah) {
                // Delete physical file if exists
                if ($majalah->cover_image) {
                    $imagePath = public_path($majalah->cover_image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $majalah->delete();
                $deleted++;
            }
        }
        
        return redirect()->route('majalah.index')->with('success', "Berhasil menghapus {$deleted} majalah.");
    }
}
