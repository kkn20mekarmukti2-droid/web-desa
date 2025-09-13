# 🏛️ Web Desa Mekarmukti

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.16.0-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.4.6-cyan?style=for-the-badge&logo=tailwindcss" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/SQLite-Production-green?style=for-the-badge&logo=sqlite" alt="SQLite">
  <img src="https://img.shields.io/badge/Firebase-Cloud-orange?style=for-the-badge&logo=firebase" alt="Firebase">
</p>

<p align="center">
  <strong>Sistem Informasi Desa Modern untuk Desa Mekarmukti</strong><br>
  Portal komprehensif dengan CMS, transparansi keuangan, dan layanan digital untuk masyarakat desa
</p>

---

## 📋 Tentang Proyek

**Web Desa Mekarmukti** adalah sistem informasi desa berbasis web yang dikembangkan untuk meningkatkan transparansi dan layanan publik di Desa Mekarmukti. Aplikasi ini menyediakan platform digital komprehensif untuk publikasi berita desa, transparansi keuangan APBDes, galeri kegiatan, profil desa, dan sistem pengaduan masyarakat dengan notifikasi real-time.

### 🎯 Fitur Utama

#### 📰 Content Management System (CMS)
- **Manajemen Artikel Desa** - Editor WYSIWYG dengan upload gambar
- **Sistem Kategori** - Organisasi konten berdasarkan topik
- **Hero Section** - Slider dinamis untuk highlight informasi penting
- **SEO Optimization** - Meta tags dan struktur URL yang SEO-friendly

#### 💰 Transparansi Keuangan
- **APBDes Dashboard** - Visualisasi anggaran dan realisasi dengan chart interaktif
- **Detail Anggaran** - Breakdown per kategori dengan persentase realisasi
- **Upload Bukti** - Sistem upload dokumen dan foto bukti realisasi
- **Export Data** - Fitur ekspor laporan dalam format Excel/PDF

#### 🏢 Profil & Informasi Desa
- **Data Desa** - Profil lengkap dengan visi, misi, dan sejarah
- **Struktur Pemerintahan** - Organigram dengan foto dan jabatan
- **Data Statistik** - Demografi penduduk dengan visualisasi chart
- **Data RT/RW** - Informasi lengkap per wilayah

#### 🖼️ Galeri & Media
- **Galeri Foto** - Dokumentasi kegiatan dengan sistem kategorisasi
- **Upload Batch** - Multiple file upload dengan preview
- **Image Optimization** - Kompresi otomatis untuk performa optimal
- **Responsive Gallery** - Layout yang adaptif untuk semua device

#### ️ UMKM & Ekonomi Desa
- **Produk UMKM** - Katalog produk lokal dengan foto dan deskripsi
- **Kontak Penjual** - Informasi kontak langsung ke penjual
- **Kategori Produk** - Organisasi produk berdasarkan jenis
- **Promosi Digital** - Platform marketing untuk UMKM lokal

#### 📱 Layanan Digital
- **Sistem Pengaduan** - Portal pengaduan masyarakat online
- **Notifikasi Push** - Firebase Cloud Messaging untuk update real-time
- **Visitor Counter** - Tracking statistik pengunjung website
- **Responsive Design** - Optimal di desktop, tablet, dan mobile

## 🛠️ Teknologi yang Digunakan

### Backend Framework
- **Laravel 11.16.0** - Modern PHP framework dengan Eloquent ORM
- **PHP 8.2+** - Server-side scripting dengan type declarations
- **SQLite** - Lightweight database untuk production (portable)
- **Composer** - Dependency management dan autoloading

### Frontend & UI/UX
- **TailwindCSS 3.4.6** - Utility-first CSS framework untuk rapid development
- **Bootstrap 5** - UI components dan grid system (hybrid approach)
- **Chart.js** - Interactive charts untuk visualisasi data APBDes
- **Vite 5.0** - Modern build tool dengan HMR support
- **JavaScript/jQuery** - Client-side interactions dan AJAX

### Cloud Services & Integrations
- **Firebase Cloud Messaging** - Push notifications real-time
- **Firebase Storage** - File storage dan CDN
- **Google Charts API** - Advanced data visualization
- **TinyMCE/CKEditor** - WYSIWYG editor untuk content management

### DevOps & Deployment
- **Git** - Version control dengan branching strategy
- **Artisan CLI** - Laravel command-line tools
- **NPM/Vite** - Asset compilation dan hot reload
- **cPanel Integration** - Production deployment automation

### Security & Performance
- **Laravel Sanctum** - API authentication
- **CSRF Protection** - Cross-site request forgery protection
- **XSS Prevention** - Input sanitization dan output escaping
- **Image Optimization** - Automatic image compression
- **Database Indexing** - Optimized query performance

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer 2.0+
- Node.js 18+ & NPM
- SQLite (sudah included)
- Web server (Apache/Nginx/Laravel Serve)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/kkn20mekarmukti2-droid/web-desa.git
   cd web-desa
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Node.js dependencies  
   npm install
   ```

3. **Environment Setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Database sudah tersedia (SQLite)
   # File: database/database.sqlite
   
   # Jika perlu migrasi ulang:
   php artisan migrate:fresh --seed
   ```

5. **Build Assets**
   ```bash
   # Development build
   npm run dev
   
   # Production build
   npm run build
   ```

6. **Storage Configuration**
   ```bash
   # Create storage link
   php artisan storage:link
   
   # Set permissions (Linux/Mac)
   chmod -R 775 storage bootstrap/cache
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Akses aplikasi di: `http://localhost:8000`

## 🌐 Deployment ke Production

### Quick Deployment
Aplikasi siap deploy dengan database SQLite yang sudah termasuk dalam repository.

```bash
# Upload semua file ke hosting
# Set permissions untuk storage dan cache
chmod -R 775 storage bootstrap/cache

# Install dependencies (jika diperlukan)
composer install --no-dev --optimize-autoloader

# Build assets
npm run build

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### cPanel Deployment
1. **Upload via File Manager atau FTP**
   - Upload semua file ke `public_html` atau folder domain
   - Database SQLite akan ikut terupload

2. **Set Permissions**
   ```bash
   # Via terminal cPanel
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

3. **Environment Production**
   - Rename `.env.production` menjadi `.env`
   - Atau edit `.env` sesuai environment production

### Firebase Configuration (Optional)
Jika menggunakan push notifications:
1. Upload `firebase_credentials.json` ke folder `config/`
2. Update Firebase config di `.env`
3. Copy `firebase-messaging-sw.js` ke folder `public/`

## 👨‍💼 Admin Panel & User Management

### Login Admin
- **URL:** `/admin` atau `/login`
- **Default Admin:**
  - Email: `admin@webdesa.com`
  - Password: `admin123`

### Fitur Admin Dashboard
- **Dashboard Analytics** - Visitor stats, content metrics
- **Content Management** - CRUD artikel dengan rich text editor
- **Media Management** - Upload dan organize galeri foto
- **UMKM Management** - Kelola produk dan kontak UMKM
- **APBDes Management** - Input dan update data anggaran
- **User Management** - Kelola akun admin dan permissions
- **Pengaduan Management** - Monitor dan respon pengaduan
- **Data Desa** - Update profil dan struktur pemerintahan

### Role System
- **Super Admin** - Full access ke semua fitur
- **Admin** - Access terbatas untuk content management
- **Editor** - Hanya bisa edit artikel dan galeri

### Security Features
- **CSRF Protection** pada semua form
- **Input Validation** dengan Laravel Form Requests
- **File Upload Security** dengan validasi type dan size
- **Session Management** dengan timeout otomatis
- **Password Hashing** menggunakan bcrypt

## 📁 Struktur Project

```
web-desa/
├── app/
│   ├── Console/Commands/     # Custom Artisan commands
│   ├── Http/
│   │   ├── Controllers/      # MVC Controllers
│   │   │   ├── AdminController.php
│   │   │   ├── ArtikelController.php
│   │   │   ├── ApbdesController.php
│   │   │   ├── GalleryController.php
│   │   │   └── UmkmController.php
│   │   └── Middleware/       # Custom middleware
│   ├── Models/              # Eloquent models
│   │   ├── artikelModel.php
│   │   ├── Apbdes.php
│   │   ├── galleryModel.php
│   │   ├── ProdukUmkm.php
│   │   ├── Pengaduan.php
│   │   └── User.php
│   └── Services/            # Business logic services
│       └── VisitorService.php
├── database/
│   ├── database.sqlite      # SQLite database (production-ready)
│   ├── migrations/          # Database schema
│   └── seeders/            # Sample data
├── public/
│   ├── build/              # Compiled assets (Vite)
│   ├── images/             # Public images
│   ├── storage/            # Symlink to storage/app/public
│   └── firebase-messaging-sw.js
├── resources/
│   ├── views/              # Blade templates
│   │   ├── layouts/        # Layout templates
│   │   ├── admin/          # Admin panel views
│   │   ├── artikel/        # Article views
│   │   └── components/     # Reusable components
│   ├── css/app.css         # Main stylesheet
│   └── js/app.js           # Main JavaScript
├── routes/
│   ├── web.php             # Web routes
│   ├── api.php             # API routes
│   └── produk_umkm.php     # UMKM specific routes
├── storage/
│   ├── app/public/         # File uploads
│   ├── framework/          # Framework cache
│   └── logs/               # Application logs
├── config/
│   ├── firebase.php        # Firebase configuration
│   └── database.php        # Database configuration
├── .env                    # Environment variables
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
├── tailwind.config.js      # TailwindCSS configuration
├── vite.config.js          # Vite build configuration
└── DOKUMENTASI_LENGKAP.md  # Complete documentation
```

## 🔧 Development & Maintenance

### Available Commands
```bash
# Development
php artisan serve              # Start development server
npm run dev                   # Watch assets for changes
npm run build                 # Build for production

# Database
php artisan migrate:fresh     # Reset database
php artisan db:seed           # Seed sample data
php artisan migrate:status    # Check migration status

# Cache Management
php artisan config:cache      # Cache configuration
php artisan route:cache       # Cache routes
php artisan view:cache        # Cache views
php artisan cache:clear       # Clear application cache

# Custom Commands
php artisan app:update-visitor-stats  # Update visitor statistics
```

### API Endpoints
```bash
# Public APIs
GET /api/articles             # Get articles with pagination
GET /api/gallery             # Get gallery photos
GET /api/apbdes              # Get APBDes data
GET /api/umkm                # Get UMKM products
GET /api/visitor-stats       # Get visitor statistics

# Admin APIs (require authentication)
POST /api/admin/articles     # Create article
PUT /api/admin/articles/{id} # Update article
DELETE /api/admin/articles/{id} # Delete article
```

### Performance Optimization
- **Database Indexing** - Optimized queries untuk artikel dan galeri
- **Image Compression** - Automatic resize untuk upload gambar
- **Lazy Loading** - JavaScript lazy loading untuk galeri
- **CDN Ready** - Asset URLs mendukung CDN integration
- **Caching Strategy** - View caching dan route caching untuk production

## 🎨 UI/UX Design & Customization

### Design System
- **Color Palette** - Primary: Blue (#3B82F6), Secondary: Green (#10B981), Accent: Orange (#F59E0B)
- **Typography** - Inter font family untuk readability optimal
- **Grid System** - 12-column responsive grid dengan Tailwind utilities
- **Component Library** - Reusable Blade components untuk consistency

### Responsive Breakpoints
```css
/* Tailwind CSS breakpoints */
sm: 640px   /* Mobile landscape */
md: 768px   /* Tablet */
lg: 1024px  /* Desktop */
xl: 1280px  /* Large desktop */
2xl: 1536px /* Extra large */
```

### Custom Styling
- **Main CSS:** `resources/css/app.css`
- **TailwindCSS Config:** `tailwind.config.js` - Extended dengan custom colors dan spacing
- **Component Styles:** Inline utility classes dengan BEM methodology fallback
- **Print Styles:** Optimized untuk printing laporan APBDes

### JavaScript Components
- **Chart Visualization** - Chart.js untuk APBDes dashboard
- **Image Gallery** - Lightbox modal dengan navigation
- **Form Validation** - Client-side validation dengan feedback
- **Mobile Navigation** - Touch-friendly hamburger menu
- **Search Autocomplete** - Real-time search suggestions

### Accessibility Features
- **ARIA Labels** - Screen reader compatibility
- **Keyboard Navigation** - Tab order dan focus management
- **Color Contrast** - WCAG 2.1 AA compliant
- **Alt Text** - Descriptive image alt attributes
- **Semantic HTML** - Proper heading hierarchy dan landmarks

## 🤝 Kontribusi & Development

Proyek ini dikembangkan sebagai bagian dari program KKN 2024 untuk Desa Mekarmukti. Kontribusi dan saran perbaikan sangat diterima:

### Development Workflow
1. **Fork repository** dan clone ke local
2. **Setup development environment** sesuai panduan instalasi
3. **Create feature branch** (`git checkout -b feature/nama-fitur`)
4. **Development dengan best practices:**
   - Follow PSR-12 coding standards untuk PHP
   - Gunakan Tailwind utilities untuk styling
   - Write meaningful commit messages
   - Test fitur sebelum commit
5. **Commit changes** (`git commit -m 'Add: deskripsi fitur'`)
6. **Push branch** (`git push origin feature/nama-fitur`)
7. **Create Pull Request** dengan deskripsi lengkap

### Code Standards
- **PHP:** PSR-12, Laravel conventions, PHPDoc comments
- **JavaScript:** ES6+, camelCase naming, JSDoc untuk functions
- **CSS:** TailwindCSS utilities, BEM untuk custom classes
- **Database:** Snake_case untuk table/column names
- **Git:** Conventional commits (feat:, fix:, docs:, style:, refactor:)

### Testing Guidelines
- **Manual Testing:** Test di berbagai browser dan device sizes
- **Database Testing:** Backup database sebelum migrasi besar
- **Performance Testing:** Check loading time dan responsive behavior
- **Security Testing:** Validate inputs dan check authorization

## 📚 Dokumentasi Lengkap

Untuk dokumentasi teknis lengkap, deployment guides, troubleshooting, dan maintenance procedures, silakan baca:

📖 **[DOKUMENTASI_LENGKAP.md](./DOKUMENTASI_LENGKAP.md)**

Dokumentasi mencakup:
- Setup detail dan konfigurasi
- Database schema dan relationships
- API documentation
- Deployment procedures
- Security guidelines
- Performance optimization
- Troubleshooting common issues

## 📞 Support & Kontak

**Tim Pengembang KKN 2024-2025 Desa Mekarmukti**

### Repository & Issues
- **GitHub Repository:** [kkn20mekarmukti2-droid/web-desa](https://github.com/kkn20mekarmukti2-droid/web-desa)
- **Report Issues:** [GitHub Issues](https://github.com/kkn20mekarmukti2-droid/web-desa/issues)
- **Feature Requests:** Gunakan GitHub Issues dengan label `enhancement`

### Social Media & Community
- **Instagram Desa:** [@mekarmukti_id](https://www.instagram.com/mekarmukti_id/)
- **Instagram KKN Politeknik LP3I:** [@kkn_mekarmuktiplb](https://www.instagram.com/kkn_mekarmuktiplb/)
- **Instagram KKN UMBandung:** [@kkn20mekarmukti2](https://www.instagram.com/kkn20mekarmukti2/)
- **YouTube Desa:** [Desa Mekarmukti](https://www.youtube.com/@desamekarmukti3378)

### Contact Information
- **Email:** desamotekar00@gmail.com
- **Telepon:** +62 851-5762-2980
- **Alamat:** Desa Mekarmukti, Kec. Cihampelas, Bandung Barat 40562

### Technical Support
- **Documentation:** Baca `DOKUMENTASI_LENGKAP.md` untuk troubleshooting
- **Community:** Diskusi via GitHub Discussions
- **Emergency Issues:** Gunakan label `bug` dan `urgent` di GitHub Issues

## 🏆 Credits & Acknowledgments

### Development Team KKN 2024-2025
Dikembangkan sejak tahun 2024 dan terus dipelihara hingga 2025 oleh:
- **Tim KKN Politeknik LP3I Bandung** - [@kkn_mekarmuktiplb](https://www.instagram.com/kkn_mekarmuktiplb/)
- **Tim KKN Universitas Muhammadiyah Bandung** - [@kkn20mekarmukti2](https://www.instagram.com/kkn20mekarmukti2/)
- **Kelompok 20 Mekarmukti (Kelompok ke-2)** - Collaborative development

### Contribution Areas
- **Full-Stack Development:** Laravel + TailwindCSS implementation
- **UI/UX Design:** Responsive design dan user experience optimization
- **Database Design:** Schema design dan data modeling
- **DevOps:** Deployment automation dan server configuration
- **Content Management:** CMS development dan admin panel
- **Community Engagement:** Social media integration dan public relations

### Technologies & Libraries
- **Laravel Framework** - Robust PHP framework untuk backend
- **TailwindCSS** - Utility-first CSS framework
- **Chart.js** - Beautiful charts untuk data visualization
- **Firebase** - Cloud messaging dan notification services
- **SQLite** - Lightweight database solution
- **Vite** - Lightning fast build tool

### Special Thanks
- **Desa Mekarmukti** - Dukungan dan kepercayaan untuk pengembangan sistem
- **Sekretariat Desa** - Bantuan data dan koordinasi implementasi
- **Masyarakat Desa** - Feedback dan testing aplikasi
- **Laravel Community** - Documentation dan best practices
- **Open Source Contributors** - Libraries dan tools yang digunakan

## 📄 Lisensi

Proyek ini dikembangkan untuk kepentingan publik **Desa Mekarmukti**. 

### License Information
- **Project License:** Developed untuk public domain Desa Mekarmukti
- **Laravel Framework:** [MIT License](https://opensource.org/licenses/MIT)
- **Dependencies:** Masing-masing library mengikuti license respective-nya
- **Usage Rights:** Free untuk development dan modification sesuai kebutuhan desa

### Copyright Notice
```
Copyright (c) 2024-2025 KKN Tim Pengembang Desa Mekarmukti
Developed for public service - Desa Mekarmukti Digital Initiative
Kelompok 20 Mekarmukti (Kelompok ke-2) • 2024-2025
```

---

<p align="center">
  <strong>🏛️ Dikembangkan dengan ❤️ untuk Desa Mekarmukti</strong><br>
  <em>KKN 2024-2025 - Membangun Desa Digital Berkelanjutan</em>
</p>
