<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Carbon\Carbon;

class PengaduanController extends Controller {
    
    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'isi' => 'required|string',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'alamat_lengkap.required' => 'Alamat lengkap harus diisi',
            'isi.required' => 'Isi pengaduan harus diisi',
        ]);
        
        // Create pengaduan with proper timezone
        Pengaduan::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat_lengkap' => $request->alamat_lengkap,
            'isi' => $request->isi,
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta'),
        ]);
        
        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaduan berhasil dikirim!']);
        }
        
        return back()->with('success','Pengaduan berhasil dikirim!');
    }
    
    public function index() {
        $pengaduan = Pengaduan::latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }
}
