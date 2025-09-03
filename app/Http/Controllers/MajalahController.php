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

        // Upload cover image dengan teknik seperti gallery
        $coverFile = $request->file('cover_image');
        $originName = $coverFile->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $coverFile->getClientOriginalExtension();
        $coverFileName = $fileName . '_' . time() . '.' . $extension;
        $coverFile->move(public_path('majalah'), $coverFileName);
        $coverPath = 'majalah/' . $coverFileName;

        // Create majalah
        $majalah = Majalah::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'cover_image' => $coverPath,
            'tanggal_terbit' => $request->tanggal_terbit,
            'is_active' => $request->boolean('is_active', true)
        ]);

        // Upload pages ke public/majalah/pages
        if ($request->hasFile('pages')) {
            // Buat folder pages jika belum ada
            $pagesDir = public_path('majalah/pages/' . $majalah->id);
            if (!file_exists($pagesDir)) {
                mkdir($pagesDir, 0755, true);
            }
            
            foreach ($request->file('pages') as $index => $page) {
                $originName = $page->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $page->getClientOriginalExtension();
                $pageFileName = 'page_' . ($index + 1) . '_' . time() . '.' . $extension;
                $page->move($pagesDir, $pageFileName);
                $pagePath = 'majalah/pages/' . $majalah->id . '/' . $pageFileName;
                
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
            if ($majalah->cover_image && file_exists(public_path($majalah->cover_image))) {
                unlink(public_path($majalah->cover_image));
            }
            
            // Upload new image dengan teknik gallery
            $coverFile = $request->file('cover_image');
            $originName = $coverFile->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $coverFile->getClientOriginalExtension();
            $coverFileName = $fileName . '_' . time() . '.' . $extension;
            $coverFile->move(public_path('majalah'), $coverFileName);
            $updateData['cover_image'] = 'majalah/' . $coverFileName;
        }

        $majalah->update($updateData);

        return redirect()->route('admin.majalah.index')
            ->with('success', 'Majalah berhasil diperbarui!');
    }

    public function destroy(Majalah $majalah)
    {
        // Delete cover image
        if ($majalah->cover_image && file_exists(public_path($majalah->cover_image))) {
            unlink(public_path($majalah->cover_image));
        }

        // Delete page images
        foreach ($majalah->pages as $page) {
            if ($page->image_path && file_exists(public_path($page->image_path))) {
                unlink(public_path($page->image_path));
            }
        }

        // Delete page directory
        $pagesDir = public_path('majalah/pages/' . $majalah->id);
        if (is_dir($pagesDir)) {
            rmdir($pagesDir);
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
            if ($page->image_path && file_exists(public_path($page->image_path))) {
                unlink(public_path($page->image_path));
            }
            
            // Upload new image
            $pageFile = $request->file('image');
            $pageFileName = 'page_' . $page->page_number . '_' . time() . '.' . $pageFile->getClientOriginalExtension();
            $pagesDir = public_path('majalah/pages/' . $page->majalah_id);
            if (!file_exists($pagesDir)) {
                mkdir($pagesDir, 0755, true);
            }
            $pageFile->move($pagesDir, $pageFileName);
            $updateData['image_path'] = 'majalah/pages/' . $page->majalah_id . '/' . $pageFileName;
        }

        $page->update($updateData);

        return response()->json(['success' => true, 'message' => 'Halaman berhasil diperbarui!']);
    }

    // Method untuk delete halaman individual
    public function deletePage(MajalahPage $page)
    {
        if ($page->image_path && file_exists(public_path($page->image_path))) {
            unlink(public_path($page->image_path));
        }
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
