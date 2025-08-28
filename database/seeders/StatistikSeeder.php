<?php

namespace Database\Seeders;

use App\Models\StatistikModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Penduduk berdasarkan Jenis Kelamin
        $jenisKelaminData = [
            ['kategori' => 'jenis_kelamin', 'label' => 'Laki-laki', 'jumlah' => 1250, 'deskripsi' => 'Penduduk laki-laki di desa'],
            ['kategori' => 'jenis_kelamin', 'label' => 'Perempuan', 'jumlah' => 1180, 'deskripsi' => 'Penduduk perempuan di desa'],
        ];

        // Data Penduduk berdasarkan Agama
        $agamaData = [
            ['kategori' => 'agama', 'label' => 'Islam', 'jumlah' => 2100, 'deskripsi' => 'Penduduk beragama Islam'],
            ['kategori' => 'agama', 'label' => 'Kristen', 'jumlah' => 180, 'deskripsi' => 'Penduduk beragama Kristen'],
            ['kategori' => 'agama', 'label' => 'Katolik', 'jumlah' => 85, 'deskripsi' => 'Penduduk beragama Katolik'],
            ['kategori' => 'agama', 'label' => 'Hindu', 'jumlah' => 45, 'deskripsi' => 'Penduduk beragama Hindu'],
            ['kategori' => 'agama', 'label' => 'Buddha', 'jumlah' => 20, 'deskripsi' => 'Penduduk beragama Buddha'],
        ];

        // Data Penduduk berdasarkan Pekerjaan
        $pekerjaanData = [
            ['kategori' => 'pekerjaan', 'label' => 'Petani', 'jumlah' => 850, 'deskripsi' => 'Petani dan pekebun'],
            ['kategori' => 'pekerjaan', 'label' => 'Wiraswasta', 'jumlah' => 420, 'deskripsi' => 'Pengusaha dan pedagang'],
            ['kategori' => 'pekerjaan', 'label' => 'Karyawan Swasta', 'jumlah' => 380, 'deskripsi' => 'Karyawan perusahaan swasta'],
            ['kategori' => 'pekerjaan', 'label' => 'PNS', 'jumlah' => 195, 'deskripsi' => 'Pegawai Negeri Sipil'],
            ['kategori' => 'pekerjaan', 'label' => 'TNI/POLRI', 'jumlah' => 45, 'deskripsi' => 'Anggota TNI dan POLRI'],
            ['kategori' => 'pekerjaan', 'label' => 'Pensiunan', 'jumlah' => 120, 'deskripsi' => 'Pensiunan PNS/TNI/POLRI'],
            ['kategori' => 'pekerjaan', 'label' => 'Pelajar/Mahasiswa', 'jumlah' => 280, 'deskripsi' => 'Pelajar dan mahasiswa'],
            ['kategori' => 'pekerjaan', 'label' => 'Ibu Rumah Tangga', 'jumlah' => 340, 'deskripsi' => 'Ibu rumah tangga'],
        ];

        // Data Kartu Keluarga
        $kkData = [
            ['kategori' => 'kk', 'label' => 'KK Laki-laki', 'jumlah' => 420, 'deskripsi' => 'Kepala keluarga laki-laki'],
            ['kategori' => 'kk', 'label' => 'KK Perempuan', 'jumlah' => 380, 'deskripsi' => 'Kepala keluarga perempuan'],
        ];

        // Insert semua data
        foreach ($jenisKelaminData as $data) {
            StatistikModel::create($data);
        }

        foreach ($agamaData as $data) {
            StatistikModel::create($data);
        }

        foreach ($pekerjaanData as $data) {
            StatistikModel::create($data);
        }

        foreach ($kkData as $data) {
            StatistikModel::create($data);
        }
    }
}
