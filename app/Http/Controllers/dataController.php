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
    
    // Special handling for data from admin statistik
    switch ($type) {
        case 'penduduk':
            return $this->getStatistikData('jenis_kelamin');
        case 'agama':
            return $this->getStatistikData('agama');
        case 'pekerjaan':
            return $this->getStatistikData('pekerjaan');
        case 'kk':
            // Keep existing KK data from MySQL if needed, or create admin interface for this too
            return $this->getKKDataFromMySQL();
    }
    
    // For other data types, use existing logic with local database
    $dataRecords = DB::table('data')->where('data', $type)->get();
    
    if ($dataRecords->isEmpty()) {
        // If no data exists, create sample data for demonstration
        $this->createSampleData($type);
        $dataRecords = DB::table('data')->where('data', $type)->get();
    }

    if ($dataRecords->isEmpty()) {
        return response()->json(['labels' => [], 'data' => []]);
    }

    $labels = $dataRecords->pluck('label')->toArray();
    // Ensure all data values are properly converted to integers
    $data = $dataRecords->pluck('total')->map(function($value) {
        return (int) $value;
    })->toArray();

    // Add debug logging for production troubleshooting
    \Log::info("Chart data for {$type}", [
        'labels' => $labels,
        'data' => $data,
        'record_count' => count($dataRecords)
    ]);

    return response()->json([
        'labels' => $labels,
        'data' => $data,
    ]);
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

private function getKKDataFromMySQL()
{
    try {
        // Create MySQL connection to mekh7277_desa database
        $mysql = DB::connection('mysql_population');
        
        // Get KK (Kepala Keluarga) statistics from datades table using the correct field names
        $kkData = $mysql->table('datades')->first();
        
        if ($kkData) {
            $kkMaleCount = (int) $kkData->KK_laki;
            $kkFemaleCount = (int) $kkData->KK_Cewek;
            
            $labels = ['KK Laki-laki', 'KK Perempuan'];
            $data = [$kkMaleCount, $kkFemaleCount];
            
            // Log the results
            \Log::info("KK data from MySQL", [
                'labels' => $labels,
                'data' => $data,
                'total' => $kkMaleCount + $kkFemaleCount,
                'source' => 'database mekh7277_desa.datades'
            ]);
            
            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);
        } else {
            \Log::warning("No KK data found in datades table");
            throw new \Exception("No KK data found in datades table");
        }
        
    } catch (\Exception $e) {
        \Log::error("Error getting KK data from MySQL: " . $e->getMessage());
        
        // Fallback to sample data if MySQL connection fails
        return response()->json([
            'labels' => ['KK Laki-laki', 'KK Perempuan'],
            'data' => [420, 380],
        ]);
    }
}

private function getPopulationDataFromMySQL()
{
    try {
        // Create MySQL connection to mekh7277_desa database
        $mysql = DB::connection('mysql_population');
        
        // Get population statistics from datades table using the correct field names
        $populationData = $mysql->table('datades')->first();
        
        if ($populationData) {
            $maleCount = (int) $populationData->Penduduk_Laki;
            $femaleCount = (int) $populationData->Penduduk_Cewek;
            
            $labels = ['Laki-laki', 'Perempuan'];
            $data = [$maleCount, $femaleCount];
            
            // Log the results
            \Log::info("Population data from MySQL", [
                'labels' => $labels,
                'data' => $data,
                'total' => $maleCount + $femaleCount,
                'source' => 'database mekh7277_desa.datades'
            ]);
            
            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);
        } else {
            \Log::warning("No data found in datades table");
            throw new \Exception("No data found in datades table");
        }
        
    } catch (\Exception $e) {
        \Log::error("Error getting population data from MySQL: " . $e->getMessage());
        
        // Fallback to sample data if MySQL connection fails
        return response()->json([
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [1250, 1180],
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
