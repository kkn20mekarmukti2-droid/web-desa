<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateRealVillageData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'village:populate-real-data {--reset : Reset all existing data first}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate database with realistic village demographic data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('reset')) {
            $this->info('🔄 Resetting existing data...');
            DB::table('data')->truncate();
        }

        $this->info('📊 Populating realistic village data...');

        // Data demografis realistis untuk desa dengan ~3000 penduduk
        $villageData = [
            // Data Penduduk (Jenis Kelamin)
            'penduduk' => [
                ['label' => 'Laki-laki', 'total' => 1580],
                ['label' => 'Perempuan', 'total' => 1420],
            ],

            // Data Kepala Keluarga
            'kk' => [
                ['label' => 'KK Laki-laki', 'total' => 720],
                ['label' => 'KK Perempuan', 'total' => 180],
            ],

            // Data Agama
            'agama' => [
                ['label' => 'Islam', 'total' => 2850],
                ['label' => 'Kristen Protestan', 'total' => 95],
                ['label' => 'Kristen Katolik', 'total' => 35],
                ['label' => 'Hindu', 'total' => 15],
                ['label' => 'Buddha', 'total' => 5],
            ],

            // Data Pendidikan
            'pendidikan' => [
                ['label' => 'Tidak Sekolah', 'total' => 180],
                ['label' => 'SD/Sederajat', 'total' => 1200],
                ['label' => 'SMP/Sederajat', 'total' => 850],
                ['label' => 'SMA/SMK/Sederajat', 'total' => 620],
                ['label' => 'Diploma/S1', 'total' => 135],
                ['label' => 'S2/S3', 'total' => 15],
            ],

            // Data Profesi/Pekerjaan (Kategori Clean - OPSI C)
            'profesi' => [
                ['label' => 'PNS & Aparatur', 'total' => 225], // PNS + TNI/Polri + Guru PNS
                ['label' => 'Pegawai Swasta', 'total' => 630], // Wiraswasta + Buruh + Pedagang + Tukang
                ['label' => 'Petani', 'total' => 680], // Sektor utama desa
                ['label' => 'Tidak Bekerja', 'total' => 545], // IRT + Pengangguran + Pensiunan
                ['label' => 'Pelajar/Mahasiswa', 'total' => 240], // Pelajar dan Mahasiswa
            ],

            // Data Kesehatan
            'kesehatan' => [
                ['label' => 'Sehat', 'total' => 2750],
                ['label' => 'Sakit Ringan/Kronis', 'total' => 185],
                ['label' => 'Penyandang Disabilitas', 'total' => 45],
                ['label' => 'Lansia (>65 tahun)', 'total' => 120],
            ],

            // Data Siswa Aktif
            'siswa' => [
                ['label' => 'TK/PAUD', 'total' => 95],
                ['label' => 'SD', 'total' => 380],
                ['label' => 'SMP', 'total' => 245],
                ['label' => 'SMA/SMK', 'total' => 185],
                ['label' => 'Mahasiswa', 'total' => 65],
            ],

            // Data Klub/Organisasi
            'klub' => [
                ['label' => 'PKK', 'total' => 45],
                ['label' => 'Karang Taruna', 'total' => 85],
                ['label' => 'Kelompok Tani', 'total' => 120],
                ['label' => 'Posyandu', 'total' => 25],
                ['label' => 'BPD', 'total' => 12],
                ['label' => 'RT/RW', 'total' => 35],
                ['label' => 'Kelompok Pengajian', 'total' => 180],
            ],

            // Data Kesenian/Budaya
            'kesenian' => [
                ['label' => 'Seni Tari Tradisional', 'total' => 35],
                ['label' => 'Musik Tradisional', 'total' => 28],
                ['label' => 'Teater/Drama', 'total' => 15],
                ['label' => 'Kerajinan Tangan', 'total' => 65],
                ['label' => 'Batik/Tenun', 'total' => 42],
                ['label' => 'Kuliner Tradisional', 'total' => 85],
            ],

            // Data Sumber Air
            'sumberair' => [
                ['label' => 'PDAM', 'total' => 420],
                ['label' => 'Sumur Bor', 'total' => 280],
                ['label' => 'Sumur Gali', 'total' => 165],
                ['label' => 'Mata Air', 'total' => 35],
            ],
        ];

        $totalInserted = 0;

        foreach ($villageData as $category => $items) {
            $this->info("📝 Inserting data for: {$category}");
            
            // Delete existing data for this category
            DB::table('data')->where('data', $category)->delete();
            
            foreach ($items as $item) {
                DB::table('data')->insert([
                    'data' => $category,
                    'label' => $item['label'],
                    'total' => $item['total'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $totalInserted++;
            }
        }

        $this->info("✅ Successfully inserted {$totalInserted} realistic data records!");
        $this->info("🏘️  Data represents a village with ~3000 residents");
        $this->line('');
        $this->info('📊 Summary:');
        $this->table(['Category', 'Records'], [
            ['Population', count($villageData['penduduk'])],
            ['Religion', count($villageData['agama'])],
            ['Education', count($villageData['pendidikan'])],
            ['Occupation', count($villageData['profesi'])],
            ['Health', count($villageData['kesehatan'])],
            ['Students', count($villageData['siswa'])],
            ['Organizations', count($villageData['klub'])],
            ['Arts/Culture', count($villageData['kesenian'])],
            ['Water Source', count($villageData['sumberair'])],
        ]);
        
        $this->line('');
        $this->info('🌐 You can now view the updated statistics at:');
        $this->line('   → /datapenduduk (Population Overview)');
        $this->line('   → /dataprofesi (Occupations)');
        $this->line('   → /datapendidikan (Education)');
        $this->line('   → And other statistical pages...');
    }
}
