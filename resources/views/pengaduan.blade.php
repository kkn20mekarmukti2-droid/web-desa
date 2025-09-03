@extends('layout.app')
@section('judul', 'Pengaduan Online - Desa Mekarmukti')
@section('content')
<main class="mt-20 w-full mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Section with Breadcrumb --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-green-600 to-teal-800 shadow-2xl mb-8">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative px-8 py-16 text-center">
                <div class="mb-4">
                    <nav class="flex justify-center" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-white/80">
                            <li class="inline-flex items-center">
                                <a href="{{ route('home') }}" class="text-white/70 hover:text-white transition-colors">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fa-solid fa-chevron-right text-white/60 mx-2"></i>
                                    <span class="text-white font-medium">Pengaduan Online</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    Pengaduan Online
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Sampaikan keluhan, saran, dan aspirasi Anda untuk kemajuan Desa Mekarmukti melalui layanan pengaduan online yang mudah dan aman
                </p>
            </div>
            <!-- Animated background elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full animate-bounce"></div>
            <div class="absolute top-1/3 right-1/3 w-12 h-12 bg-white/5 rounded-full animate-ping"></div>
        </div>

        {{-- Information Cards --}}
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            @php
                $infoCards = [
                    [
                        'icon' => 'shield-check',
                        'title' => 'Keamanan Data',
                        'description' => 'Data pribadi Anda akan dijaga kerahasiaan sesuai dengan ketentuan yang berlaku',
                        'color' => 'blue'
                    ],
                    [
                        'icon' => 'clock',
                        'title' => 'Respon Cepat',
                        'description' => 'Pengaduan Anda akan ditindaklanjuti dalam waktu maksimal 3x24 jam kerja',
                        'color' => 'green'
                    ],
                    [
                        'icon' => 'users',
                        'title' => 'Transparansi',
                        'description' => 'Proses penanganan pengaduan dilakukan secara transparan dan akuntabel',
                        'color' => 'purple'
                    ]
                ];
            @endphp

            @foreach($infoCards as $card)
                <div class="bg-white rounded-2xl shadow-lg border border-{{ $card['color'] }}-100 p-6 text-center hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="bg-gradient-to-r from-{{ $card['color'] }}-500 to-{{ $card['color'] }}-600 p-4 rounded-full w-fit mx-auto mb-4">
                        <i class="fa-solid fa-{{ $card['icon'] }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $card['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $card['description'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Main Form Section --}}
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6">
                        <h2 class="text-3xl font-bold text-white flex items-center">
                            <i class="fa-solid fa-comment-dots mr-4"></i>
                            Form Pengaduan
                        </h2>
                        <p class="text-green-100 mt-2">Isi form di bawah ini dengan lengkap dan jelas</p>
                    </div>

                    <div class="p-8">
                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-check-circle text-green-600 text-xl mr-3"></i>
                                    <div>
                                        <h4 class="text-green-800 font-semibold">Pengaduan Berhasil Dikirim!</h4>
                                        <p class="text-green-600 text-sm mt-1">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Error Messages --}}
                        @if($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                                <div class="flex items-start">
                                    <i class="fa-solid fa-exclamation-triangle text-red-600 text-xl mr-3 mt-1"></i>
                                    <div>
                                        <h4 class="text-red-800 font-semibold">Terdapat Kesalahan:</h4>
                                        <ul class="text-red-600 text-sm mt-2 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>• {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('pengaduan.store') }}" method="POST" class="space-y-6" id="pengaduanForm">
                            @csrf
                            
                            {{-- Nama --}}
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fa-solid fa-user text-green-600 mr-2"></i>
                                    Nama Lengkap *
                                </label>
                                <input type="text" name="nama" id="nama" required
                                       value="{{ old('nama') }}"
                                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 {{ $errors->has('nama') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-green-500 focus:border-green-500' }}"
                                       placeholder="Masukkan nama lengkap Anda">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fa-solid fa-phone text-orange-600 mr-2"></i>
                                    Nomor HP / WhatsApp *
                                </label>
                                <input type="tel" name="no_hp" id="no_hp" required
                                       value="{{ old('no_hp') }}"
                                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 {{ $errors->has('no_hp') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-orange-500 focus:border-orange-500' }}"
                                       placeholder="Contoh: 08123456789">
                                @error('no_hp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat Lengkap --}}
                            <div>
                                <label for="alamat_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fa-solid fa-map-marker-alt text-blue-600 mr-2"></i>
                                    Alamat Lengkap *
                                </label>
                                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" required
                                          class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 resize-none {{ $errors->has('alamat_lengkap') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                          placeholder="Contoh: Jl. Merdeka No. 123, RT/RW 01/02, Desa Mekarmukti, Kec. Cihampelas">{{ old('alamat_lengkap') }}</textarea>
                                @error('alamat_lengkap')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Isi Pengaduan --}}
                            <div>
                                <label for="isi" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fa-solid fa-file-text text-indigo-600 mr-2"></i>
                                    Isi Pengaduan *
                                </label>
                                <textarea name="isi" id="isi" rows="6" required
                                          class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 resize-none {{ $errors->has('isi') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}"
                                          placeholder="Tuliskan keluhan, saran, atau aspirasi Anda secara detail dan jelas. Sertakan informasi seperti lokasi kejadian, waktu, dan hal-hal penting lainnya...">{{ old('isi') }}</textarea>
                                <div class="flex justify-between items-center mt-2">
                                    @error('isi')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @else
                                        <p class="text-gray-500 text-sm">
                                            <i class="fa-solid fa-lightbulb mr-1"></i>
                                            Tips: Berikan informasi yang lengkap agar kami dapat memproses pengaduan Anda dengan lebih baik
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button type="submit" 
                                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center justify-center group">
                                    <i class="fa-solid fa-paper-plane mr-2 group-hover:animate-pulse"></i>
                                    Kirim Pengaduan
                                </button>
                                <button type="reset" 
                                        class="flex-1 bg-gray-200 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-300 transition-colors duration-300 flex items-center justify-center">
                                    <i class="fa-solid fa-eraser mr-2"></i>
                                    Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar Information --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Panduan --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fa-solid fa-info-circle mr-3"></i>
                            Panduan Pengaduan
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @php
                            $panduan = [
                                ['Isi form dengan lengkap dan jelas', 'check', 'green'],
                                ['Gunakan bahasa yang sopan dan santun', 'heart', 'pink'],
                                ['Cantumkan detail lokasi jika diperlukan', 'map-marker-alt', 'red'],
                                ['Tunggu respon maksimal 3x24 jam', 'clock', 'blue'],
                                ['Cek email/HP untuk update pengaduan', 'bell', 'yellow']
                            ];
                        @endphp
                        
                        @foreach($panduan as $item)
                            <div class="flex items-start space-x-3">
                                <div class="bg-{{ $item[2] }}-100 p-2 rounded-full mt-1 flex-shrink-0">
                                    <i class="fa-solid fa-{{ $item[1] }} text-{{ $item[2] }}-600 text-sm"></i>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $item[0] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Kontak Darurat --}}
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <div class="text-center">
                        <div class="bg-red-500 p-3 rounded-full w-fit mx-auto mb-4">
                            <i class="fa-solid fa-exclamation-triangle text-white text-2xl"></i>
                        </div>
                        <h4 class="text-red-800 font-bold text-lg mb-2">Keadaan Darurat?</h4>
                        <p class="text-red-600 text-sm mb-4">Untuk situasi mendesak, hubungi langsung:</p>
                        <a href="tel:+6281234567890" 
                           class="bg-red-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-red-600 transition-colors duration-300 inline-flex items-center">
                            <i class="fa-solid fa-phone mr-2"></i>
                            0812-3456-7890
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation and submission
        const form = document.getElementById('pengaduanForm');
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner animate-spin mr-2"></i>Mengirim...';
        });

        // Auto-resize textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });

        // Phone number formatting
        const phoneInput = document.querySelector('input[name="no_hp"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                // Ensure starts with 08 or 628
                if (value.startsWith('8')) {
                    value = '0' + value;
                } else if (value.startsWith('628')) {
                    // Keep as is (international format)
                }
                
                e.target.value = value;
            });
        }

        // Form reset functionality
        const resetBtn = document.querySelector('button[type="reset"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                textareas.forEach(textarea => {
                    textarea.style.height = 'auto';
                });
            });
        }

        // Success message auto-hide
        const successAlert = document.querySelector('.bg-green-50');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 300);
            }, 5000);
        }
    });
</script>
@endsection
