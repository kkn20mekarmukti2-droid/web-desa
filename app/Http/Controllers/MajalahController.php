<?php

namespace App\Http\Controllers;

use App\Models\Majalah;
use App\Models\MajalahPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajalahController extends Controller
{
    public function adminIndex()
    {
        $majalah = Majalah::orderBy('created_at', 'desc')->get();
        return view('admin.majalah.index', compact('majalah'));
    }
    
    public function publicIndex()
    {
        $majalah = Majalah::where('is_active', true)->orderBy('created_at', 'desc')->get();
        return view("public.majalah", compact('majalah'));
    }

    public function getPages($id)
    {
        try {
            $majalah = Majalah::findOrFail($id);
            $pages = $majalah->pages()->orderBy('page_number')->get();
            
            return response()->json([
                'success' => true,
                'magazine' => [
                    'id' => $majalah->id,
                    'judul' => $majalah->judul,
                    'deskripsi' => $majalah->deskripsi,
                    'total_pages' => $majalah->total_pages,
                ],
                'pages' => $pages->map(function($page) {
                    return [
                        'id' => $page->id,
                        'title' => $page->title,
                        'page_number' => $page->page_number,
                        'image_path' => $page->image_path
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Majalah tidak ditemukan'
            ], 404);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $majalah = Majalah::findOrFail($id);
            $majalah->is_active = !$majalah->is_active;
            $majalah->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status majalah berhasil diubah',
                'is_active' => $majalah->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status majalah'
            ], 500);
        }
    }
}
