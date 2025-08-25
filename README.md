# 🏛️ Web Desa Mekarmukti

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.45.2-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.4.6-cyan?style=for-the-badge&logo=tailwindcss" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/MySQL-Production-orange?style=for-the-badge&logo=mysql" alt="MySQL">
</p>

<p align="center">
  <strong>Sistem Informasi Desa Modern untuk Desa Mekarmukti</strong><br>
  Portal berita, informasi, dan layanan digital untuk masyarakat desa
</p>

---

## 📋 Tentang Proyek

**Web Desa Mekarmukti** adalah sistem informasi desa berbasis web yang dikembangkan untuk meningkatkan transparansi dan layanan publik di Desa Mekarmukti. Aplikasi ini menyediakan platform digital untuk publikasi berita desa, informasi kegiatan, pengumuman, dan layanan administrasi online.

### 🎯 Fitur Utama

- **📰 Manajemen Berita Desa** - Publikasi berita dan artikel dengan sistem kategori
- **🖼️ Galeri Foto** - Dokumentasi kegiatan dan fasilitas desa  
- **👨‍💼 Admin Dashboard** - Panel admin untuk pengelolaan konten
- **📱 Responsive Design** - Tampilan optimal di desktop dan mobile
- **🔐 Sistem Autentikasi** - Login admin dengan keamanan yang baik
- **🗂️ Kategori Artikel** - Organisasi konten berdasarkan topik
- **🔍 Sistem Pencarian** - Pencarian artikel dan informasi

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 11.45.2** - PHP Framework
- **PHP 8.2+** - Server-side scripting
- **MySQL** - Database production
- **Composer** - Dependency management

### Frontend  
- **TailwindCSS 3.4.6** - Utility-first CSS framework
- **Bootstrap 5** - UI components (hybrid approach)
- **Vite 5.0** - Modern build tool
- **JavaScript/jQuery** - Client-side interactions

### Tools & Services
- **Git** - Version control
- **Firebase** - Push notifications (configured)
- **cPanel** - Production hosting environment

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL database
- Web server (Apache/Nginx)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/kkn20mekarmukti2-droid/web-desa.git
   cd web-desa
   ```

2. **Install Dependencies**
   ```bash
   # PHP dependencies
   composer install
   
   # Node.js dependencies  
   npm install
   ```

3. **Environment Setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **Database Configuration**
   ```bash
   # Edit .env file dengan kredensial database
   # Jalankan migrasi
   php artisan migrate
   
   # Seed data (opsional)
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Storage Link**
   ```bash
   php artisan storage:link
   ```

## 🌐 Deployment ke cPanel

### Deployment Otomatis
```bash
# Jalankan script deployment
bash cpanel-deploy.sh
```

### Manual Deployment
1. **Upload files ke cPanel**
2. **Update dependencies:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
3. **Fix storage link:**
   ```bash
   bash fix-storage-link.sh
   ```

📖 **Panduan lengkap:** Lihat `DEPLOYMENT_GUIDE.md`

## 👨‍💼 Manajemen Admin

### Login Admin
- **URL:** `/login`
- **Default credentials:** admin123 (untuk semua akun)

### Reset Password Admin
```bash
# Reset password admin
php artisan admin:reset-password

# Cleanup duplikat user
bash simple-cleanup.sh
```

### Manajemen User
- Cleanup duplikat: `simple-cleanup.sh`
- Reset multi-admin: `php artisan admin:multi-reset`

## 📁 Struktur Project

```
web-desa/
├── app/
│   ├── Console/Commands/     # Artisan commands
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/                  # Public assets
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript
├── routes/                  # Route definitions
├── storage/                # Storage & logs
├── cpanel-deploy.sh        # Deployment script
├── simple-cleanup.sh       # User cleanup tool
└── fix-storage-link.sh     # Storage fix untuk cPanel
```

## 🔧 Maintenance & Tools

### Scripts Tersedia
- `cpanel-deploy.sh` - Deployment automation
- `simple-cleanup.sh` - User management & cleanup  
- `fix-storage-link.sh` - Storage link fixes
- `force-cleanup-update.sh` - Emergency cleanup

### Artisan Commands
- `php artisan admin:reset-password` - Reset admin password
- `php artisan admin:multi-reset` - Multi-admin management
- `php artisan admin:cleanup-users-fixed` - Advanced user cleanup

📖 **Dokumentasi tools:** Lihat `SCRIPTS_README.md`

## 🎨 Kustomisasi

### Theme & Styling
- **Main CSS:** `resources/css/app.css`
- **TailwindCSS Config:** `tailwind.config.js`
- **Vite Config:** `vite.config.js`

### Views & Templates
- **Layout:** `resources/views/layouts/app.blade.php`
- **Home:** `resources/views/home.blade.php`  
- **Admin:** `resources/views/admin/`

## 🤝 Kontribusi

Proyek ini dikembangkan sebagai bagian dari program KKN 2024. Kontribusi dan saran perbaikan sangat diterima:

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📞 Support & Kontak

**Tim Pengembang KKN 2024**
- **Repository:** [kkn20mekarmukti2-droid/web-desa](https://github.com/kkn20mekarmukti2-droid/web-desa)
- **Issues:** [GitHub Issues](https://github.com/kkn20mekarmukti2-droid/web-desa/issues)

## 📄 Lisensi

Proyek ini dikembangkan untuk kepentingan publik Desa Mekarmukti. 
Framework Laravel yang digunakan berlisensi [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  <strong>🏛️ Dikembangkan dengan ❤️ untuk Desa Mekarmukti</strong><br>
  <em>KKN 2024 - Membangun Desa Digital</em>
</p>
