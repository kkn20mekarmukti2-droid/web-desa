# Hero Welcome Component Documentation

## Overview
Komponen Hero Welcome yang menggantikan carousel lama dengan desain modern yang konsisten dengan header gelap dan aksen oranye logo Motekar. **Menampilkan 4 background images yang berganti otomatis dengan efek slideshow.**

## Features Implemented
✅ **Multiple Background Images**: 4 gambar berbeda yang berganti setiap 5 detik
✅ **Smooth Slideshow Animation**: Transisi halus antar gambar (20s total cycle)
✅ **Visual Indicators**: Indikator titik yang menunjukkan slide aktif
✅ **Modern Typography**: Judul responsif dengan gradient orange accent
✅ **CTA Buttons**: Primary (orange) dan Secondary (transparent with border)
✅ **Wave Divider**: SVG wave sebagai pemisah section
✅ **Accessibility**: Proper ARIA labels, semantic HTML
✅ **Responsive**: Mobile-first design dengan breakpoints
✅ **Performance**: CSS-only animation, no JavaScript
✅ **Fallback**: Support untuk prefers-reduced-motion

## Background Images Used
1. **IMG_9152.png** - Image utama (0-5s)
2. **BACKGROUND_1721464283.jpg** - Background alternatif 1 (5-10s)
3. **BACKGROUND_1722505452.jpg** - Background alternatif 2 (10-15s)
4. **WhatsApp Image 2024-12-10 at 16.56.18_209b0322_1733828508.jpg** - Background alternatif 3 (15-20s)

## Animation Details
- **Total Duration**: 20 seconds per cycle
- **Image Transition**: Smooth fade between backgrounds
- **Slide Timing**: 5 seconds per image
- **Indicators**: Orange active indicator with animation sync
- **Fallback**: Static first image untuk reduced motion

## File Structure
```
resources/views/components/hero-welcome.blade.php  // Main component with slideshow
resources/views/index.blade.php                   // Updated homepage
public/img/IMG_9152.png                           // Hero image 1
public/img/BACKGROUND_1721464283.jpg              // Hero image 2  
public/img/BACKGROUND_1722505452.jpg              // Hero image 3
public/img/WhatsApp Image...                      // Hero image 4
```

## Color Scheme (Logo Motekar)
- Primary Orange: #F59E0B (indicators, buttons)
- Hover Orange: #FFA500
- Background: Black to Gray gradient overlay
- Text: White with orange accents

## CSS Animation Structure
```css
@keyframes bg-slideshow {
  0%, 25%   { background-image: img1 }  // 0-5s
  25%, 50%  { background-image: img2 }  // 5-10s  
  50%, 75%  { background-image: img3 }  // 10-15s
  75%, 100% { background-image: img4 }  // 15-20s
}
```

## Responsive Breakpoints
- Mobile: min-h-[60vh], text-4xl
- Medium: min-h-[70vh], text-5xl  
- Large: text-6xl

## CTA Buttons
1. **Primary**: "Profil Desa" → /about (Orange background)
2. **Secondary**: "Galeri Desa" → /galeri (Transparent with white border)

## Usage
```blade
@include('components.hero-welcome')
```

## Dependencies
- Tailwind CSS CDN
- Bootstrap Icons CDN
- Laravel Blade templating
- Asset helper untuk gambar multiple

## Browser Support
- Modern browsers dengan CSS animations
- Fallback untuk reduced motion preference
- Responsive pada semua device sizes
- Optimized image loading

## Maintenance
- **Add Images**: Tambah URL di @keyframes bg-slideshow dan sesuaikan timing
- **Change Timing**: Ubah animation duration dan keyframe percentages
- **Update CTA**: Edit button hrefs dalam component
- **Update Colors**: Modify Tailwind classes atau CSS variables
