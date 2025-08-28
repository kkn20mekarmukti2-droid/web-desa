{{-- Hero Welcome Component - Desain Motekar dengan Layout Grid --}}
{{-- Background slideshow dengan overlay gradasi dan konten kiri --}}

<style>
/* Hero Background Slideshow */
.hero-bg {
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    animation: bgSlideshow 35s ease-in-out infinite;
}

@keyframes bgSlideshow {
    0%, 13.28% { background-image: url('{{ asset("img/DSC_0070.JPG") }}'); }
    14.28%, 27.56% { background-image: url('{{ asset("img/DSC_0108.jpg") }}'); }
    28.56%, 41.84% { background-image: url('{{ asset("img/DSC_0828.JPG") }}'); }
    42.84%, 56.12% { background-image: url('{{ asset("img/IMG_9152.png") }}'); }
    57.12%, 70.40% { background-image: url('{{ asset("img/kades.jpg") }}'); }
    71.40%, 84.68% { background-image: url('{{ asset("img/P1560599.JPG") }}'); }
    85.68%, 99.96% { background-image: url('{{ asset("img/P1570155.JPG") }}'); }
    100% { background-image: url('{{ asset("img/DSC_0070.JPG") }}'); }
}

/* Content Animation */
@keyframes fadeInLeft {
    0% {
        opacity: 0;
        transform: translateX(-30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Clean bottom edge - no wave needed */

/* Mobile Responsive */
@media (max-width: 1024px) {
    .hero-bg { background-position: center 30%; }
}

@media (max-width: 768px) {
    .hero-bg { 
        background-position: center 25%; 
        min-height: 60vh;
    }
    
    /* Better mobile spacing */
    .hero-content {
        padding: 0 1rem;
    }
    
    /* Touch-friendly button */
    .hero-cta-button {
        min-height: 48px;
        padding: 12px 24px;
        font-size: 16px;
    }
}
</style>

{{-- Hero Section --}}
<section class="relative h-[60vh] md:h-[70vh] lg:h-[80vh] hero-bg">
    {{-- Background Overlay Gradasi --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
    
    {{-- Grid Container --}}
    <div class="relative z-10 container mx-auto px-4 h-full hero-content">
        <div class="grid grid-cols-12 h-full items-center">
            {{-- Konten Kiri (6 kolom) --}}
            <div class="lg:col-span-6 col-span-12 space-y-4 md:space-y-6" style="animation: fadeInLeft 1.5s ease-out;">
                
                {{-- Caption Kecil --}}
                <p class="text-white/80 text-xs md:text-sm lg:text-base font-medium tracking-wide uppercase">
                    Selamat Datang di Website Resmi
                </p>
                
                {{-- Judul Utama --}}
                <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight">
                    <span class="text-white">Desa</span>
                    <span class="block text-[#F59E0B] mt-1 md:mt-2">Mekarmukti</span>
                </h1>
                
                {{-- Subline Motto --}}
                <p class="text-white/90 text-sm md:text-lg lg:text-xl font-light tracking-wider">
                    MAJU • PROFESIONAL • TANGGUH • KREATIF • RELIGIUS
                </p>
                
                {{-- Call to Action Button --}}
                <div class="pt-4 md:pt-6">
                    <a href="{{ route('data.statistik') }}" 
                       class="hero-cta-button inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-[#F59E0B] text-black font-semibold text-base md:text-lg rounded-lg hover:bg-[#F59E0B]/90 focus:ring-4 focus:ring-[#F59E0B]/50 transition-all duration-300 transform hover:scale-105 shadow-xl">
                        <i class="bi bi-graph-up me-2 md:me-3"></i>
                        Jelajahi Data Desa
                    </a>
                </div>
                
            </div>
            
            {{-- Kolom Kanan (kosong untuk visual balance) --}}
            <div class="lg:col-span-6 col-span-12 hidden lg:block">
                {{-- Intentionally empty for visual balance --}}
            </div>
        </div>
    </div>
</section>
