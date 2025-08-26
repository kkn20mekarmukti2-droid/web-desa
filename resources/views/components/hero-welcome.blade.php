{{-- Hero Welcome Component dengan Wave Effect --}}
{{-- Konsisten dengan header gelap dan aksen oranye Motekar --}}

<style>
/* Hero Wave Effect Styles */
.hero-wave-container {
    position: absolute;
    inset: 0;
    z-index: 5;
}

/* SVG Anti-outline fix */
svg {
    border: none !important;
    outline: none !important;
    stroke: none !important;
}

svg path {
    border: none !important;
    outline: none !important;
    stroke: none !important;
    stroke-width: 0 !important;
}

.hero-background {
    position: absolute;
    left: 50%;
    top: 0;
    width: 140%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center 20%;
    border-radius: 0 0 50% 50%;
    transform: translateX(-50%) rotate(0deg);
    z-index: 8;
    transition: background-image 1s ease-in-out;
    animation: slideshow 35s ease-in-out infinite;
}

.hero-wave-overlay {
    position: absolute;
    left: 50%;
    top: 0;
    width: 140%;
    height: 101%;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(245, 158, 11, 0.2) 100%);
    border-radius: 0 0 50% 50%;
    transform: translateX(-50%) translateY(8px) rotate(1deg);
    z-index: 10;
}

/* Slideshow Animation */
@keyframes slideshow {
    0%, 13.28% { 
        background-image: url('{{ asset("img/DSC_0070.JPG") }}');
    }
    14.28%, 27.56% { 
        background-image: url('{{ asset("img/DSC_0108.jpg") }}');
    }
    28.56%, 41.84% { 
        background-image: url('{{ asset("img/DSC_0828.JPG") }}');
    }
    42.84%, 56.12% { 
        background-image: url('{{ asset("img/IMG_9152.png") }}');
    }
    57.12%, 70.40% { 
        background-image: url('{{ asset("img/kades.jpg") }}');
    }
    71.40%, 84.68% { 
        background-image: url('{{ asset("img/P1560599.JPG") }}');
    }
    85.68%, 99.96% { 
        background-image: url('{{ asset("img/P1570155.JPG") }}');
    }
    100% { 
        background-image: url('{{ asset("img/DSC_0070.JPG") }}');
    }
}

/* Content Animations */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Indicator Animation */
@keyframes bg-indicator {
    0%, 13.28% { 
        background-color: rgba(245, 158, 11, 0.8);
        transform: scale(1.2);
    }
    14.28%, 100% { 
        background-color: rgba(255, 255, 255, 0.5);
        transform: scale(1);
    }
}

/* Mobile Responsive */
@media (max-width: 640px) {
    .hero-background {
        width: 150%;
        height: 95%;
        background-position: center 15%;
    }
    .hero-wave-overlay {
        width: 150%;
        height: 96%;
    }
}

@media (prefers-reduced-motion: reduce) {
    .hero-background {
        animation: none;
        background-image: url('{{ asset("img/DSC_0070.JPG") }}');
    }
}
</style>

{{-- Hero Section dengan Wave Effect --}}
<section class="relative w-full h-screen overflow-hidden bg-gradient-to-b from-gray-900 to-black">
    {{-- Background Slideshow dengan Wave Shape --}}
    <div class="hero-wave-container">
        <div class="hero-background"></div>
        <div class="hero-wave-overlay"></div>
    </div>

    {{-- Content Overlay --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white z-20 px-4">
        <div class="max-w-4xl mx-auto space-y-6" style="animation: fadeInUp 1.5s ease-out;">
            <h1 class="text-5xl md:text-7xl font-bold leading-tight">
                Selamat Datang di
                <span class="block bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Desa Mekarmukti</span>
            </h1>
            <p class="text-xl md:text-2xl font-light leading-relaxed opacity-90 max-w-3xl mx-auto">
                MAJU • PROFESIONAL • TANGGUH • KREATIF • RELIGIUS
            </p>
            <div class="pt-8">
                <a href="#statistik" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold text-lg rounded-full shadow-2xl hover:shadow-orange-500/25 hover:scale-105 transition-all duration-300">
                    <i class="bi bi-arrow-down-circle me-2"></i>
                    Jelajahi Data Desa
                </a>
            </div>
        </div>
    </div>

    {{-- Slideshow Indicators --}}
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
        <div class="w-2 h-2 rounded-full bg-orange-500 shadow-lg" style="animation: bg-indicator 35s ease-in-out infinite;"></div>
        <div class="w-2 h-2 rounded-full bg-white/50" style="animation: bg-indicator 35s ease-in-out infinite; animation-delay: 5s;"></div>
        <div class="w-2 h-2 rounded-full bg-white/50" style="animation: bg-indicator 35s ease-in-out infinite; animation-delay: 10s;"></div>
        <div class="w-2 h-2 rounded-full bg-white/50" style="animation: bg-indicator 35s ease-in-out infinite; animation-delay: 15s;"></div>
        <div class="w-2 h-2 rounded-full bg-white/50" style="animation: bg-indicator 35s ease-in-out infinite; animation-delay: 20s;"></div>
        <div class="w-2 h-2 rounded-full bg-white/50" style="animation: bg-indicator 35s ease-in-out infinite; animation-delay: 25s;"></div>
        <div class="w-2 h-2 rounded-full bg-white/50" style="animation: bg-indicator 35s ease-in-out infinite; animation-delay: 30s;"></div>
    </div>
</section>

{{-- Wave Divider SVG - Seamless tanpa outline hitam --}}
<div style="position: relative; margin-top: -4px; background: #EAF2F7;">
    <svg width="100%" height="80" viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block;">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="#EAF2F7"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="#EAF2F7"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#EAF2F7"></path>
    </svg>
</div>
