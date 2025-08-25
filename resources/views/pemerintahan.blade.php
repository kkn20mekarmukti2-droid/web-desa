@extends('layout.app')
@section('content')
    <main id="main">

        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Pemerintahan</h2>
                    <ol>
                        <li><a href="{{route('home')}}">Beranda</a></li>
                        <li>Stuktur Pemerintahan</li>
                    </ol>
                </div>

            </div>
        </section>

        <section class="features">
            <div class="container">

                <div class="section-title">
                    <h2>Visi & Misi Desa Mekarmukti</h2>
                    <p>Berdasarkan kondisi saat ini dan tantangan yang akan

                        dihadapi dalam enam tahun mendatang serta dengan mempertimbangkan modal dasar yang dimiliki,
                        gambaran dari
                        masalah dan potensi yang ada di Desa Mekarmukti serta keinginan yang harus terbukti dimasa enam
                        tahun kedepan
                        agar tujuan dan sasaran yang ingin dicapai dapat terukur dan terkendali.
                    </p>
                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-md-5">
                        <img src="assets/img/pamong2.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-7 pt-4">
                        <h3>VISI</h3>
                        <p class="fst-italic">
                            Dengan demikian, Visi dan Misi Kepala Desa Mekarmukti untuk Tahun 2021 – 2027 yaitu
                        </p>
                        <p><b>MOTEKAR</b></p>
                        <ul>
                            <li><i class="bi bi-check"></i> <b>Maju</b></li>
                            <li><i class="bi bi-check"></i> <b>Profesional</b></li>
                            <li><i class="bi bi-check"></i> <b>Tangguh</b></li>
                            <li><i class="bi bi-check"></i> <b>Kreatif</b></li>
                            <li><i class="bi bi-check"></i> <b>Religius</b></li>
                        </ul>
                    </div>
                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-md-5 order-1 order-md-2">
                        <img src="assets/img/pamong3.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-7 pt-5 order-2 order-md-1">
                        <h3>Misi </h3>
                        <p class="fst-italic">
                            Visi berada diatas Misi sehingga Visi kemudian dijabarkan kedalam misi untuk dapat dilaksanakan,
                            maka Misi
                            Desa Mekarmuktia adalah:
                        </p>

                        <ul>
                            <li><i class="bi bi-check"></i> Pelayanan administrasi desa berbasis digital dan transparansi
                                anggaran.
                            </li>
                            <li><i class="bi bi-check"></i> Perbaikan sarana infrastruktur. </li>
                            <li><i class="bi bi-check"></i> Bangun tempat pengolahan sampah terpadu / TPST 3R.</li>
                            <li><i class="bi bi-check"></i> Bantuan modal bergulir bagi UMKM.
                            </li>
                            <li><i class="bi bi-check"></i> Subsidi dana kesehatan untuk dhuafa. </li>
                            <li><i class="bi bi-check"></i> Kadedeh tahunan bagi guru ngaji, anak yatim & dhuafa.</li>
                            <li><i class="bi bi-check"></i> Alokasi dana pertanian & perikanan.</li>
                            <li><i class="bi bi-check"></i> Beasiswa pelajar berprestasi & dhuafa. </li>
                            <li><i class="bi bi-check"></i> Stadion mini / lapang desa.</li>
                            <li><i class="bi bi-check"></i> Membangun sanggar seni & budaya </li>

                        </ul>
                    </div>
                </div>

            </div>
        </section>
        
        <section class="why-us section-bg" data-aos="fade-up" date-aos-delay="200">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 video-box">
                        <img src="assets/img/pamong4.jpg" class="img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-center p-5">

                        <div class="icon-box">
                
                            <h4 class="title !ml-0"><a href="">Aparatur Pemerintahan</a></h4>
                            <p class="description !ml-0">Jumlah perangakat Desa Mekarmukti Tahun 2021 sebanyak 11 orang terdiri
                                dari:</p>
                            <ul class="list-group">
                                <li class="list-group-item"> Kepala Desa : 1 Orang </li>
                                <li class="list-group-item"> Sekretaris Desa : 1 Orang </li>
                                <li class="list-group-item"> Kepala Urusan : 3 Orang </li>
                                <li class="list-group-item"> Kepala Kasi : 3 Orang </li>
                                <li class="list-group-item"> Kepala Dusun : 4 Orang </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </section>
        
       <section class="service-details mb-10">
            <div class="container">

                <div class="row text-lg-center">

                    <div class="flex justify-center w-full">
                        <div class="w-full grid grid-cols-2 sm:grid-cols-6 max-sm:gap-3 gap-5">
                            <div class="col-span-2 sm:block hidden"></div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400 col-span-2">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/kades.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-base sm:text-xl">ANDRIAWAN BURHANUDIN, SH</h2>
                                    <h3 class="underline font-semibold">KEPALA DESA</h3>
                                </div>
                            </div>
                            <div class="col-span-2 sm:block hidden"></div>
                            <div class="col-span-2 sm:block hidden"></div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400 col-span-2 scale-95">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/sekdes.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-base sm:text-xl">YADI DAMANHURI, ST</h2>
                                    <h3 class="underline font-semibold">Sekretaris Desa</h3>
                                </div>
                            </div>
                            <div class="col-span-2 sm:block hidden"></div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/lalan.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">LALAN JAELANI</h2>
                                    <h3 class="underline max-sm:text-xs font-semibold">Kasi Kesejahteraan</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/nengia.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">NENG IA FITRI A</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kaur Keuangan</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/asfa.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-sm">ASFHA NUGRAHA ARIFIN</h2>
                                    <h3 class="underline   max-sm:text-xs font-semibold">Kasi Pemerintahaan</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/wahyu.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">WAHYU HADIAN, SE</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kaur Perencanaan</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/uun.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">TISNA UNDAYA</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kaur Tata Usaha</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/dewi.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">DEWI LISTIANI ABIDIN</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kasi Pelayanan</h3>
                                </div>
                            </div>
                            <div class="col-span-1 max-sm:hidden"></div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/encep.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">ENCEP MULYANA</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kadus I</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/ridwan.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">AGUS RIDWAN</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kadus II</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/febri.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">FEBRI HARDIANSYAH</h2>
                                    <h3 class="underline   max-sm:text-xsfont-semibold">Kadus III</h3>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 bg-white border-b-2 sm:hover:scale-125 transition-all border-yellow-400">
                                <div class="col-span-1"><img src="{{ asset('img/perangkat/peri.jpg') }}" alt=""
                                        class=" w-full aspect-square object-cover"></div>
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <h2 class="text-xs sm:text-base">PERI</h2>
                                    <h3 class="underline  max-sm:text-xs font-semibold">Kadus IV</h3>
                                </div>
                            </div>
                            <div class="col-span-1"></div>
                        </div>

                    </div>
                </div>
        </section>

    </main>
@endsection
@section('script')
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
    </script>
@endsection
