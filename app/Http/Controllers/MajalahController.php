<?php

namespace App\Http\Controllers;

use App\Models\Majalah;
use App\Models\MajalahPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MajalahController extends Controller
{
    // Public view untuk halaman majalah desa
    public function publicIndex()
    {
        $majalah = Majalah::where('is_active', true)
            ->orderBy('tanggal_terbit', 'desc')
            ->get();
            
        $totalMajalah = $majalah->count();
        $totalHalaman = $majalah->sum('total_pages');

        return view('public.majalah', compact('majalah', 'totalMajalah', 'totalHalaman'));
    }
    
    // Admin CRUD Methods
    public function index()
    {
        $majalah = Majalah::with('pages')
            ->orderBy('tanggal_terbit', 'desc')
            ->get();
            
        return view('admin.majalah.index', compact('majalah'));
    }

    public function create()
    {
        return view('admin.majalah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_terbit' => 'required|date',
            'is_active' => 'boolean',
            'pages' => 'required|array|min:1',
            'pages.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload cover image
        $coverPath = $request->file('cover_image')->store('majalah/covers', 'public');

        // Create majalah
        $majalah = Majalah::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'cover_image' => $coverPath,
            'tanggal_terbit' => $request->tanggal_terbit,
            'is_active' => $request->boolean('is_active', true)
        ]);

        // Upload pages
        if ($request->hasFile('pages')) {
            foreach ($request->file('pages') as $index => $page) {
                $pagePath = $page->store('majalah/pages/' . $majalah->id, 'public');
                
                MajalahPage::create([
                    'majalah_id' => $majalah->id,
                    'page_number' => $index + 1,
                    'image_path' => $pagePath
                ]);
            }
        }

        return redirect()->route('admin.majalah.index')
            ->with('success', 'Majalah berhasil ditambahkan!');
    }

    public function show(Majalah $majalah)
    {
        $majalah->load('pages');
        return view('admin.majalah.show', compact('majalah'));
    }

    public function edit(Majalah $majalah)
    {
        $majalah->load('pages');
        return view('admin.majalah.edit', compact('majalah'));
    }

    public function update(Request $request, Majalah $majalah)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_terbit' => 'required|date',
            'is_active' => 'boolean'
        ]);

        $updateData = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_terbit' => $request->tanggal_terbit,
            'is_active' => $request->boolean('is_active', true)
        ];

        // Update cover image if provided
        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($majalah->cover_image) {
                Storage::disk('public')->delete($majalah->cover_image);
            }
            $updateData['cover_image'] = $request->file('cover_image')->store('majalah/covers', 'public');
        }

        $majalah->update($updateData);

        return redirect()->route('admin.majalah.index')
            ->with('success', 'Majalah berhasil diperbarui!');
    }

    public function destroy(Majalah $majalah)
    {
        // Delete cover image
        if ($majalah->cover_image) {
            Storage::disk('public')->delete($majalah->cover_image);
        }

        // Delete page images
        foreach ($majalah->pages as $page) {
            Storage::disk('public')->delete($page->image_path);
        }

        $majalah->delete();

        return redirect()->route('admin.majalah.index')
            ->with('success', 'Majalah berhasil dihapus!');
    }

    // Method untuk update halaman individual
    public function updatePage(Request $request, MajalahPage $page)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($page->image_path);
            
            // Upload new image
            $updateData['image_path'] = $request->file('image')->store(
                'majalah/pages/' . $page->majalah_id, 
                'public'
            );
        }

        $page->update($updateData);

        return response()->json(['success' => true, 'message' => 'Halaman berhasil diperbarui!']);
    }

    // Method untuk delete halaman individual
    public function deletePage(MajalahPage $page)
    {
        Storage::disk('public')->delete($page->image_path);
        $page->delete();

        return response()->json(['success' => true, 'message' => 'Halaman berhasil dihapus!']);
    }

    // Method untuk toggle status aktif
    public function toggleActive(Majalah $majalah)
    {
        $majalah->update(['is_active' => !$majalah->is_active]);
        
        $status = $majalah->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'success' => true, 
            'message' => "Majalah berhasil $status!",
            'is_active' => $majalah->is_active
        ]);
    }

    /**
     * API endpoint to get magazine pages for flipbook
     */
    public function getPages($id)
    {
        $majalah = Majalah::with('pages')->findOrFail($id);
        
        if (!$majalah->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Majalah tidak aktif'
            ], 404);
        }

        $pages = $majalah->pages()
            ->orderBy('page_number')
            ->select('page_number', 'image_path', 'title', 'description')
            ->get();

        return response()->json([
            'success' => true,
            'magazine' => [
                'id' => $majalah->id,
                'judul' => $majalah->judul,
                'deskripsi' => $majalah->deskripsi,
                'total_pages' => $majalah->total_pages
            ],
            'pages' => $pages
        ]);
    }
}
