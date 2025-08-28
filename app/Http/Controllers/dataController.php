<?php

namespace App\Http\Controllers;

use App\Models\dataModel;
use App\Models\rwModel;
use App\Models\StatistikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dataController extends Controller
{
    public function penduduk()
    {
        return view("datapenduduk");
    }
    public function kk()
    {
        return view("datakk");
    }
    public function pendidikan()
    {
        return view("datapendidikan");
    }
    public function kesehatan()
    {
        return view("datakesehatan");
    }
    public function siswa()
    {
        return view("datasiswa");
    }
    public function profesi()
    {
        return view("dataprofesi");
    }
    public function klub()
    {
        return view("dataklub");
    }
    public function kesenian()
    {
        return view("datakesenian");
    }
    public function sumberair()
    {
        return view("datasumberair");
    }

public function getChartData(Request $request)
{
    $type = $request->query('type');
    
    // All chart data now comes from admin statistik table
    switch ($type) {
        case 'penduduk':
            return $this->getStatistikData('jenis_kelamin');
        case 'agama':
            return $this->getStatistikData('agama');
        case 'pekerjaan':
            return $this->getStatistikData('pekerjaan');
        case 'kk':
            // KK data also uses admin statistik system now
            return $this->getStatistikData('kk');
        case 'rt_rw':
            return $this->getStatistikData('rt_rw');
        default:
            // For any other types, check if admin has configured data
            return $this->getStatistikData($type);
    }
}

/**
 * Get data from admin statistik table
 */
private function getStatistikData($kategori)
{
    try {
        $statistik = StatistikModel::getDataByKategori($kategori);
        
        if ($statistik->count() > 0) {
            $labels = $statistik->pluck('label')->toArray();
            $data = $statistik->pluck('jumlah')->map(function($value) {
                return (int) $value;
            })->toArray();
            
            // Log the results
            \Log::info("Statistik data from admin for {$kategori}", [
                'labels' => $labels,
                'data' => $data,
                'total' => array_sum($data),
                'source' => 'admin statistik table'
            ]);
            
            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);
        } else {
            // Return empty data if no admin data found
            \Log::warning("No admin statistik data found for kategori: {$kategori}");
            return response()->json([
                'labels' => [],
                'data' => [],
            ]);
        }
        
    } catch (\Exception $e) {
        \Log::error("Error getting statistik data for {$kategori}: " . $e->getMessage());
        
        // Fallback to empty data
        return response()->json([
            'labels' => [],
            'data' => [],
        ]);
    }
}

private function createSampleData($type)
{
    switch ($type) {
        case 'penduduk':
            DB::table('data')->insert([
                ['data' => 'penduduk', 'label' => 'Laki-laki', 'total' => 1250, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'penduduk', 'label' => 'Perempuan', 'total' => 1180, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'kk':
            DB::table('data')->insert([
                ['data' => 'kk', 'label' => 'KK Laki-laki', 'total' => 420, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'kk', 'label' => 'KK Perempuan', 'total' => 380, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'pendidikan':
            DB::table('data')->insert([
                ['data' => 'pendidikan', 'label' => 'SD', 'total' => 450, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'pendidikan', 'label' => 'SMP', 'total' => 380, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'pendidikan', 'label' => 'SMA', 'total' => 320, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'pendidikan', 'label' => 'Perguruan Tinggi', 'total' => 120, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'profesi':
            DB::table('data')->insert([
                ['data' => 'profesi', 'label' => 'Petani', 'total' => 450, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'profesi', 'label' => 'Wiraswasta', 'total' => 280, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'profesi', 'label' => 'PNS', 'total' => 85, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'profesi', 'label' => 'Karyawan Swasta', 'total' => 195, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'kesehatan':
            DB::table('data')->insert([
                ['data' => 'kesehatan', 'label' => 'Sehat', 'total' => 2200, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'kesehatan', 'label' => 'Sakit Ringan', 'total' => 180, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'kesehatan', 'label' => 'Sakit Berat', 'total' => 50, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'siswa':
            DB::table('data')->insert([
                ['data' => 'siswa', 'label' => 'SD', 'total' => 280, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'siswa', 'label' => 'SMP', 'total' => 220, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'siswa', 'label' => 'SMA', 'total' => 180, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'siswa', 'label' => 'Mahasiswa', 'total' => 95, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'klub':
            DB::table('data')->insert([
                ['data' => 'klub', 'label' => 'Sepak Bola', 'total' => 35, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'klub', 'label' => 'Badminton', 'total' => 28, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'klub', 'label' => 'Voli', 'total' => 22, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'klub', 'label' => 'Tenis Meja', 'total' => 18, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'kesenian':
            DB::table('data')->insert([
                ['data' => 'kesenian', 'label' => 'Tari Tradisional', 'total' => 25, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'kesenian', 'label' => 'Musik', 'total' => 40, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'kesenian', 'label' => 'Teater', 'total' => 15, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'kesenian', 'label' => 'Kerajinan', 'total' => 30, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'sumberair':
            DB::table('data')->insert([
                ['data' => 'sumberair', 'label' => 'Sumur Bor', 'total' => 180, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'sumberair', 'label' => 'PDAM', 'total' => 320, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'sumberair', 'label' => 'Sumur Gali', 'total' => 150, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'sumberair', 'label' => 'Mata Air', 'total' => 50, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
            
        case 'agama':
            DB::table('data')->insert([
                ['data' => 'agama', 'label' => 'Islam', 'total' => 2180, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'agama', 'label' => 'Kristen', 'total' => 180, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'agama', 'label' => 'Katolik', 'total' => 55, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'agama', 'label' => 'Hindu', 'total' => 12, 'created_at' => now(), 'updated_at' => now()],
                ['data' => 'agama', 'label' => 'Buddha', 'total' => 3, 'created_at' => now(), 'updated_at' => now()],
            ]);
            break;
    }
}


    public function sinkron(Request $request)
    {

        $type = $request->input('type');
        $data = $request->input('data');
        dataModel::where('data', $type)->delete();
        foreach ($data as $i) {
            dataModel::insert([
                'data'=> $type,
                'label'=> $i['label'],
                'total'=> $i['total'],
            ]);
        }

        return response("Berhasil Sinkron");
    }
    public function rw($rw){
        $rw = rwModel::with(['rts' => function ($query) {
            $query->orderBy('rt');
        }])->where('rw', $rw)->first();
        return view('rw', compact('rw'));
    }
}
