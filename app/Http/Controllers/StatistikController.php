<?php

namespace App\Http\Controllers;

use App\Models\StatistikModel;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Display a listing of statistics.
     */
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'jenis_kelamin');
        $statistik = StatistikModel::where('kategori', $kategori)
                                  ->orderBy('label')
                                  ->get();
        
        $kategoriOptions = StatistikModel::getKategoriOptions();
        
        return view('admin.statistik.index', compact('statistik', 'kategori', 'kategoriOptions'));
    }

    /**
     * Show the form for creating a new statistic.
     */
    public function create(Request $request)
    {
        $kategori = $request->get('kategori', 'jenis_kelamin');
        $kategoriOptions = StatistikModel::getKategoriOptions();
        
        return view('admin.statistik.create', compact('kategori', 'kategoriOptions'));
    }

    /**
     * Store a newly created statistic in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:jenis_kelamin,agama,pekerjaan,kk,rt_rw,pendidikan,kesehatan,siswa,klub,kesenian,sumberair',
            'label' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        StatistikModel::create([
            'kategori' => $request->kategori,
            'label' => $request->label,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.statistik.index', ['kategori' => $request->kategori])
                        ->with('success', 'Data statistik berhasil ditambahkan!');
    }

    /**
     * Display the specified statistic.
     */
    public function show(StatistikModel $statistik)
    {
        return view('admin.statistik.show', compact('statistik'));
    }

    /**
     * Show the form for editing the specified statistic.
     */
    public function edit(StatistikModel $statistik)
    {
        $kategoriOptions = StatistikModel::getKategoriOptions();
        
        return view('admin.statistik.edit', compact('statistik', 'kategoriOptions'));
    }

    /**
     * Update the specified statistic in storage.
     */
    public function update(Request $request, StatistikModel $statistik)
    {
        $request->validate([
            'kategori' => 'required|in:jenis_kelamin,agama,pekerjaan,kk,rt_rw,pendidikan,kesehatan,siswa,klub,kesenian,sumberair',
            'label' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $statistik->update([
            'kategori' => $request->kategori,
            'label' => $request->label,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.statistik.index', ['kategori' => $request->kategori])
                        ->with('success', 'Data statistik berhasil diperbarui!');
    }

    /**
     * Remove the specified statistic from storage.
     */
    public function destroy(StatistikModel $statistik)
    {
        $kategori = $statistik->kategori;
        $statistik->delete();

        return redirect()->route('admin.statistik.index', ['kategori' => $kategori])
                        ->with('success', 'Data statistik berhasil dihapus!');
    }
}
