<?php

namespace App\Http\Controllers;

use App\Models\galleryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class galleryController extends Controller
{
    public function index()
    {
        $artikel = (Auth::user()->role == 0)
        ? galleryModel::all()
        : galleryModel::where('created_by', Auth::user()->id)->get();
        $galleries = galleryModel::all();
        return view('admin.gallery.manage', compact('galleries'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'type' => 'required|in:foto,youtube,tiktok',
        ]);

        $type = $request->input('type');
        $url = $request->input('url');

        $gallery = new galleryModel();
        $gallery->judul = $request->input('judul');
        $gallery->type = $request->input('type');
        if ($type == 'foto') {

                $originName = $request->file('url')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('url')->getClientOriginalExtension();
                $nama = $fileName . '_' . time() . '.' . $extension;
                $request->file('url')->move(public_path('galeri'), $nama);
                $gallery->url = $nama;

        } elseif ($type == 'youtube') {
            $gallery->url = str_replace('watch?v=', 'embed/', $request->input('youtube'));
        } elseif ($type == 'tiktok') {
            $pattern = "/video\/(\d+)/";
            preg_match($pattern, $request->input('tiktok'), $video);
            $gallery->url = $video[1];
        }
        $gallery->created_by = Auth::user()->id;
        $gallery->save();

        return redirect()->route('gallery.index')->with('pesan', 'Foto/video berhasil ditambahkan.');
    }
    public function galeri()
    {
        $gallery = galleryModel::all();
        return view("galeri", compact('gallery'));
    }


    public function destroy($id)
    {
        $gallery = galleryModel::findOrFail($id);
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
