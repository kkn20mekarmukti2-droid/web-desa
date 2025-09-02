<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroImage;
use Illuminate\Support\Str;

class HeroImageController extends Controller
{
    /**
     * Delete physical image file if exists
     */
    private function deleteImageIfExists(?string $path): void
    {
        if (!$path) return;

        // Possible locations for hero images
        $candidates = [];
        // If path already includes 'img/hero/' treat it as relative under public
        if (str_starts_with($path, 'img/hero/')) {
            $candidates[] = public_path($path);
        }
        // If path starts with 'hero/' (old disk relative), map to public/storage/hero
        if (str_starts_with($path, 'hero/')) {
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

    /**
     * Display a listing of hero images (admin only)
     */
    public function index()
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $imageList = HeroImage::ordered()->paginate(12);
        
        return view('admin.hero-images.index', compact('imageList'));
    }

    /**
     * Show the form for creating a new hero image
     */
    public function create()
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('admin.hero-images.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        return view('admin.hero-images.create');
    }

    /**
     * Store a newly created hero image
     */
    public function store(Request $request)
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('admin.hero-images.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $request->validate([
            'nama_gambar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            $heroImage = new HeroImage();
            $heroImage->nama_gambar = $request->nama_gambar;
            $heroImage->deskripsi = $request->deskripsi;
            $heroImage->urutan = $request->urutan;
            $heroImage->is_active = $request->has('is_active');

            // Handle file upload - save to public/img/hero/ directory
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->nama_gambar) . '.' . $file->getClientOriginalExtension();
                
                // Ensure directory exists
                $uploadPath = public_path('img/hero');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move file to public/img/hero/
                $file->move($uploadPath, $filename);
                $heroImage->gambar = 'img/hero/' . $filename;
            }

            $heroImage->save();

            return redirect()->route('admin.hero-images.index')
                           ->with('success', 'Gambar hero berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan gambar hero: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified hero image
     */
    public function show(string $id)
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('admin.hero-images.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        $heroImage = HeroImage::findOrFail($id);
        return view('admin.hero-images.show', compact('heroImage'));
    }

    /**
     * Show the form for editing the specified hero image
     */
    public function edit($id)
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('admin.hero-images.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
        
        $heroImage = HeroImage::findOrFail($id);
        return view('admin.hero-images.edit', compact('heroImage'));
    }

    /**
     * Update the specified hero image
     */
    public function update(Request $request, string $id)
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('admin.hero-images.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $heroImage = HeroImage::findOrFail($id);

        $request->validate([
            'nama_gambar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            $heroImage->nama_gambar = $request->nama_gambar;
            $heroImage->deskripsi = $request->deskripsi;
            $heroImage->urutan = $request->urutan;
            $heroImage->is_active = $request->has('is_active');

            // Handle file upload if new image provided
            if ($request->hasFile('gambar')) {
                // Delete old image
                $this->deleteImageIfExists($heroImage->gambar);
                
                // Upload new image
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->nama_gambar) . '.' . $file->getClientOriginalExtension();
                
                // Ensure directory exists
                $uploadPath = public_path('img/hero');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move file to public/img/hero/
                $file->move($uploadPath, $filename);
                $heroImage->gambar = 'img/hero/' . $filename;
            }

            $heroImage->save();

            return redirect()->route('admin.hero-images.index')
                           ->with('success', 'Gambar hero berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui gambar hero: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified hero image
     */
    public function destroy(string $id)
    {
        // Only allow admin access
        if (!auth()->check()) {
            return redirect()->route('admin.hero-images.index')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        try {
            $heroImage = HeroImage::findOrFail($id);
            
            // Delete physical file
            $this->deleteImageIfExists($heroImage->gambar);
            
            // Delete record
            $heroImage->delete();

            return redirect()->route('admin.hero-images.index')
                           ->with('success', 'Gambar hero berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus gambar hero: ' . $e->getMessage());
        }
    }
}
