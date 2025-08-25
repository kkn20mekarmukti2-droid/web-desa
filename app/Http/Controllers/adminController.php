<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\artikelModel;
use App\Models\kategoriModel;
use App\Models\rtModel;
use App\Models\rwModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use session;

class adminController extends Controller
{
    public function dashboard()
    {
        $profil = Auth::user();
        $artikel = (Auth::user()->role == 0)
            ? artikelModel::with('getKategori')->get()
            : artikelModel::with('getKategori')->where('created_by', Auth::user()->id)->get();
        $kategori = kategoriModel::where('id','!=', 0)->get();
        return view('admin.content.manage', compact('profil', 'artikel', 'kategori'));
    }
    public function addartikel()
    {
        $kategori = kategoriModel::all();
        return view('admin.content.add', compact('kategori'));
    }
    public function deleteartikel($id)
    {
        $artikel = artikelModel::findOrFail($id);
        if (Auth::user()->id != $artikel->created_by || Auth::user()->role != 0) {
            return redirect()->route('dashboard')->with('error', 'Tidak Memiliki Akses');
        }
        $artikel->delete();

        return redirect()->route('dashboard')->with('pesan', 'Berita Berhasil di Hapus');
    }
    public function storeartikel(Request $request)
    {

        $request->validate([
            'judul' => 'required|string|max:255',
            'head' => 'nullable|string|max:255',
            'uploadType' => 'required|in:image,youtube',
            'content' => 'nullable|string',
            'kategori' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        if ($request->uploadType == 'image') {
            $request->validate([
                'sampul' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:200048',
            ]);
        } elseif ($request->uploadType == 'youtube') {
            $request->validate([
                'sampul' => 'required|url',
            ]);
        }
        if ($request->uploadType == 'image' && $request->hasFile('sampul')) {

            $originName = $request->file('sampul')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('sampul')->getClientOriginalExtension();
            $sampul = $fileName . '_' . time() . '.' . $extension;
            $request->file('sampul')->move(public_path('img'), $sampul);
        } elseif ($request->uploadType == 'youtube') {
            $sampul = str_replace('watch?v=', 'embed/', $request->sampul);
        }

        $artikel = new artikelModel();
        $artikel->judul = $request->judul;
        $artikel->header = $request->head;
        $artikel->sampul = $sampul;
        $artikel->deskripsi = $request->content;
        $artikel->kategori = $request->kategori;
        $artikel->status = $request->status;
        $artikel->created_by = Auth::user()->id;
        $artikel->save();

        return redirect()->route('dashboard')->with('pesan', 'Artikel Berhasil Ditambahkan!');
    }
    public function preview($id)
    {
        $artikel = artikelModel::with('creator')->where("id", $id)->first();
        if (!(Auth::user()->role == 0 || $artikel->created_by == Auth::user()->id)) {
            $artikel = null;
        }

        if (!$artikel) {
            if (session()->has('url.intended')) {
                return redirect()->back();
            } else {
                return redirect()->route('dashboard');
            }
        }
        $rekomendasi = artikelModel::with('getKategori', 'creator')->where('status', true)->inRandomOrder()->take(6)->get();

        return view('detailartikel', ['artikel' => $artikel, 'rekomendasi' => $rekomendasi]);
    }

    public function editartikel($id)
    {
        $artikel = artikelModel::findOrFail($id);
        $kategori = kategoriModel::all();
        return view('admin.content.edit', compact('artikel', 'kategori'));
    }

    public function updateartikel(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'head' => 'nullable|string|max:255',
            'uploadType' => 'required|in:image,youtube',
            'content' => 'nullable|string',
            'kategori' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $artikel = artikelModel::findOrFail($id);

        if ($request->uploadType == 'image') {
            $request->validate([
                'sampul' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        } elseif ($request->uploadType == 'youtube') {
            $request->validate([
                'sampul' => 'nullable|url',
            ]);
        }

        $sampul = $artikel->sampul;
        if ($request->uploadType == 'image' && $request->hasFile('sampul')) {
            $originName = $request->file('sampul')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('sampul')->getClientOriginalExtension();
            $sampul = $fileName . '_' . time() . '.' . $extension;
            $request->file('sampul')->move(public_path('img'), $sampul);

            if ($artikel->sampul && file_exists(public_path('img/' . $artikel->sampul))) {
                unlink(public_path('img/' . $artikel->sampul));
            }
        } elseif ($request->uploadType == 'youtube' && $request->sampul) {
            $sampul = str_replace('watch?v=', 'embed/', $request->sampul);
        }

        $artikel->judul = $request->judul;
        $artikel->header = $request->head;
        $artikel->sampul = $sampul;
        $artikel->deskripsi = $request->content;
        $artikel->kategori = $request->kategori;
        $artikel->status = $request->status;
        $artikel->save();

        return redirect()->route('dashboard')->with('pesan', 'Artikel Berhasil Diedit!');
    }

    public function tambahkategori(Request $request)
    {
        if (Auth::user()->role != 0) {
            return redirect()->route('dashboard')->with('error', 'tidak di izinkan');
        }
        $request->validate([
            'judul' => 'required|string|max:255',
        ]);

        $kategori = new kategoriModel();
        $kategori->judul = $request->input('judul');
        $kategori->save();

        return redirect()->route('dashboard')->with('pesan', 'Kategori Baru Berhasil di Tambahkan.');
    }

    public function deletekategori($id)
    {
        if (Auth::user()->role != 0) {
            return redirect()->route('dashboard')->with('error', 'tidak di izinkan');
        }
        $kategori = kategoriModel::with('artikel')->findOrFail($id);
        if ($kategori->artikel->isNotEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Kategori tidak bisa dihapus, karena masih digunakan');
        }
        $kategori->delete();

        return redirect()->route('dashboard')->with('pesan', 'Kategori Berhasil Dihapus');
    }

    public function uploadimg(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('img'), $fileName);
            $url = asset('img/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
    public function upprofile(Request $request)
    {
        $image = $request->file('image');
        $imageName = time() . '-' . $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img'), $imageName);
        $db = User::find(Auth::user()->id);
        $db->foto = $imageName;
        $db->save();
        return redirect()->route('dashboard');
    }
    public function ubahstatus(Request $request)
    {
        $status = $request->status ? 1 : 0;
        $id = $request->id;
        $post = artikelModel::find($id);
        $post->status = $status;
        $post->save();
        return redirect()->route('dashboard');
    }
    public function rtrw()
    {
        $rws = rwModel::with(['rts' => function ($query) {
            $query->orderBy('rt');
        }])->get();
        return view('admin.rtrw.manage', compact('rws'));
    }
    public function rwadd()
    {

        return view('admin.rtrw.addrw');
    }
    public function rwstore(Request $request)
    {
        $request->validate([
            'rw' => 'required',
            'nama' => 'required',
            'kontak' => 'nullable',
            'foto' => 'nullable|image',
        ]);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            $originName = $request->file('foto')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('foto')->move(public_path('img/rtrw'), $fileName);
            $data['foto'] = 'img/rtrw/' . $fileName;
        }

        rwModel::create($data);

        return redirect()->route('rtrw')->with('pesan', 'RW Berhasil di Tambahkan.');
    }

    public function rwdelete($id)
    {
        $rw = rwModel::findOrFail($id);
        $rw->delete();

        return redirect()->route('rtrw')->with('pesan', 'RW Berhasil di Hapus.');
    }
    public function rtadd($rw_id)
    {
        $rw = rwModel::where('rw', $rw_id)->first();
        return view('admin.rtrw.addrt', compact('rw'));
    }
    public function rtstore(Request $request)
    {
        $request->validate([
            'rw' => 'required',
            'nama' => 'required',
            'kontak' => 'nullable',
            'foto' => 'nullable|image',
            'rt' => 'required|integer'
        ]);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            $originName = $request->file('foto')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('foto')->move(public_path('img/rtrw'), $fileName);
            $data['foto'] = 'img/rtrw/' . $fileName;
        }

        rtModel::create($data);

        return redirect()->route('rtrw')->with('pesan', 'RT Berhasil di Tambahkan.');
    }

    public function rtdelete($id)
    {
        $rw = rtModel::findOrFail($id);
        $rw->delete();

        return redirect()->route('rtrw')->with('pesan', 'RT Berhasil di Hapus.');
    }
}
