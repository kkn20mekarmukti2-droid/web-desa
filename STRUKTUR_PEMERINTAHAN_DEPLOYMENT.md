# STRUKTUR PEMERINTAHAN DEPLOYMENT GUIDE

## Deployment untuk cPanel

### 1. Database Installation
1. Login ke **cPanel → phpMyAdmin**
2. Pilih database `web_desa`
3. Import file: `cpanel-struktur-pemerintahan-table.sql`
4. Atau copy-paste isi file SQL ke tab SQL

### 2. File Upload
Upload semua files yang sudah di-push ke GitHub:
```bash
git pull origin main
```

### 3. Directory Permissions
Pastikan folder foto perangkat ada dan readable:
```bash
chmod 755 public/img/perangkat/
```

### 4. Verification
Setelah deployment, buka halaman:
- `/pemerintahan` - Halaman publik dengan tampilan baru
- `/admin/struktur-pemerintahan` - Admin management (setelah login)

### 5. Expected Results
- ✅ Total records: 12
- ✅ Kepala Desa: 1 person
- ✅ Sekretaris: 1 person  
- ✅ Kepala Urusan: 3 persons
- ✅ Kepala Seksi: 3 persons
- ✅ Kepala Dusun: 4 persons

## Features Added

### Public Page (`/pemerintahan`)
- ✅ Modern responsive design with gradient hero
- ✅ Interactive organizational chart
- ✅ Visi & Misi dalam card layout
- ✅ Statistik aparatur visual
- ✅ Dynamic data dari database
- ✅ Fallback image handling

### Admin Ready (Tinggal buat views)
- ✅ Full CRUD controller
- ✅ Routes sudah ready
- ✅ Model dengan validation
- ✅ Image upload handling (APBDes pattern)
- ✅ Auth protection

### Database Schema
```sql
struktur_pemerintahans:
- id (auto increment)
- nama (varchar 255)
- jabatan (varchar 255) 
- foto (varchar 255, nullable)
- urutan (int, default 1)
- kategori (enum: kepala_desa, sekretaris, kepala_urusan, kepala_seksi, kepala_dusun)
- pendidikan (varchar 100, nullable)
- tugas_pokok (text, nullable)
- no_sk (varchar 100, nullable)  
- tgl_sk (date, nullable)
- is_active (boolean, default true)
- timestamps
```

## Commit Info
- **Commit ID**: 1cf2327
- **Message**: "Add modern government structure page with CRUD ready"
- **Date**: September 1, 2025
- **Files**: 7 files changed, 740 insertions(+), 1 deletion(-)

## Next Steps (Optional)
1. Buat admin views untuk CRUD management
2. Tambah menu di admin sidebar
3. Implementasi pencarian/filter di admin
4. Export/import functionality
