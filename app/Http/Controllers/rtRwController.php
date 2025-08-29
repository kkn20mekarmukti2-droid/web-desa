<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rwModel;
use App\Models\rtModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class rtRwController extends Controller
{
    public function manageModern()
    {
        try {
            $rw = rwModel::orderBy('rw', 'asc')->get();
            $rt = rtModel::orderBy('rt', 'asc')->get();
            
            return view('admin.rtrw.manage-modern', [
                'rw' => $rw,
                'rt' => $rt
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeRW(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rw' => 'required|integer|min:1|unique:rw,rw',
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:20'
        ], [
            'nomor_rw.required' => 'Nomor RW harus diisi',
            'nomor_rw.integer' => 'Nomor RW harus berupa angka',
            'nomor_rw.unique' => 'Nomor RW sudah terdaftar',
            'nama.required' => 'Nama ketua RW harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambah RW: ' . $validator->errors()->first());
        }

        try {
            $rw = new rwModel();
            $rw->rw = $request->nomor_rw;
            $rw->nama = $request->nama;
            $rw->kontak = $request->kontak;
            $rw->save();

            return redirect()->route('rtrw.manage.modern')
                ->with('success', 'RW ' . $request->nomor_rw . ' berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    public function updateRW(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rw' => 'required|integer|min:1|unique:rw,rw,' . $id,
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:20'
        ], [
            'nomor_rw.required' => 'Nomor RW harus diisi',
            'nomor_rw.integer' => 'Nomor RW harus berupa angka',
            'nomor_rw.unique' => 'Nomor RW sudah terdaftar',
            'nama.required' => 'Nama ketua RW harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate RW: ' . $validator->errors()->first());
        }

        try {
            $rw = rwModel::findOrFail($id);
            $oldNomor = $rw->rw;
            
            $rw->rw = $request->nomor_rw;
            $rw->nama = $request->nama;
            $rw->kontak = $request->kontak;
            $rw->save();

            return redirect()->route('rtrw.manage.modern')
                ->with('success', 'RW ' . $oldNomor . ' berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate: ' . $e->getMessage());
        }
    }

    public function deleteRW($id)
    {
        try {
            $rw = rwModel::findOrFail($id);
            $nomorRW = $rw->rw;
            
            // Check if there are RT under this RW
            $rtCount = rtModel::where('rw', $nomorRW)->count();
            
            // Delete all RT first, then RW
            DB::transaction(function () use ($nomorRW, $rw) {
                rtModel::where('rw', $nomorRW)->delete();
                $rw->delete();
            });

            $message = $rtCount > 0 
                ? "RW $nomorRW dan $rtCount RT di dalamnya berhasil dihapus!" 
                : "RW $nomorRW berhasil dihapus!";

            return redirect()->route('rtrw.manage.modern')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }

    public function storeRT(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rt' => 'required|integer|min:1',
            'rw_id' => 'required|exists:rw,id',
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:20'
        ], [
            'nomor_rt.required' => 'Nomor RT harus diisi',
            'nomor_rt.integer' => 'Nomor RT harus berupa angka',
            'rw_id.required' => 'RW harus dipilih',
            'rw_id.exists' => 'RW yang dipilih tidak valid',
            'nama.required' => 'Nama ketua RT harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambah RT: ' . $validator->errors()->first());
        }

        try {
            $rwData = rwModel::findOrFail($request->rw_id);
            
            // Check for duplicate RT in the same RW
            $existingRT = rtModel::where('rt', $request->nomor_rt)
                            ->where('rw', $rwData->rw)
                            ->first();

            if ($existingRT) {
                return redirect()->back()
                    ->with('error', 'RT ' . $request->nomor_rt . ' sudah ada di RW ' . $rwData->rw . '!');
            }
            
            $rt = new rtModel();
            $rt->rt = $request->nomor_rt;
            $rt->rw = $rwData->rw;
            $rt->nama = $request->nama;
            $rt->kontak = $request->kontak;
            $rt->save();

            return redirect()->route('rtrw.manage.modern')
                ->with('success', 'RT ' . $request->nomor_rt . ' berhasil ditambahkan ke RW ' . $rwData->rw . '!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    public function updateRT(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rt' => 'required|integer|min:1',
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:20'
        ], [
            'nomor_rt.required' => 'Nomor RT harus diisi',
            'nomor_rt.integer' => 'Nomor RT harus berupa angka',
            'nama.required' => 'Nama ketua RT harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate RT: ' . $validator->errors()->first());
        }

        try {
            $rt = rtModel::findOrFail($id);
            $oldNomor = $rt->rt;
            
            // Check for duplicate RT in the same RW (excluding current RT)
            $existingRT = rtModel::where('rt', $request->nomor_rt)
                            ->where('rw', $rt->rw)
                            ->where('id', '!=', $id)
                            ->first();

            if ($existingRT) {
                return redirect()->back()
                    ->with('error', 'RT ' . $request->nomor_rt . ' sudah ada di RW ' . $rt->rw . '!');
            }
            
            $rt->rt = $request->nomor_rt;
            $rt->nama = $request->nama;
            $rt->kontak = $request->kontak;
            $rt->save();

            return redirect()->route('rtrw.manage.modern')
                ->with('success', 'RT ' . $oldNomor . ' berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate: ' . $e->getMessage());
        }
    }

    public function deleteRT($id)
    {
        try {
            $rt = rtModel::findOrFail($id);
            $nomorRT = $rt->rt;
            $nomorRW = $rt->rw;
            
            $rt->delete();

            return redirect()->route('rtrw.manage.modern')
                ->with('success', "RT $nomorRT dari RW $nomorRW berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }
}
