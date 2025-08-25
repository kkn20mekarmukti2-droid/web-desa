@extends('layout.app')
@section('judul', 'Kontak Desa Mekarmukti')
@section('content')

    <main id="main">

        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Kontak</h2>
                    <ol>
                        <li><a href="index.html">Beranda </a></li>
                        <li>Kontak</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
            <div class="container">

                <div class="grid grid-cols-2 max-sm:grid-cols-1 gap-5">

                    <div class="max-sm:order-2">

                        <div class="grid max-sm:grid-cols-2 max-sm:gap-5 md:gap-x-5">
                            <div class="col-span-2">
                                <div class="info-box">
                                    <i class="bx bx-map"></i>
                                    <h3>Alamat Kami</h3>
                                    <p>Desa Mekarmukti
                                        Kec.Cihampelas, 40562
                                        Kab.Bandung Barat, Jawa Barat </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="info-box">
                                    <i class="bx bx-envelope"></i>
                                    <h3>Email Kami</h3>
                                    <p>pelayanan@mekarmukti.id</p>
                                </div>
                            </div>
                            <div class="">
                                <div class="info-box">
                                    <i class="bx bx-phone-call"></i>
                                    <h3>Hubungi Kami</h3>
                                    <p>+62 857-9812-1885</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="">
                         <form action="{{ route('send.message') }}" method="POST" role="form" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="my-3">

                            </div>
                            <div class="text-center"><button type="submit">Kirim Pesan</button></div>

                        </form>
                    </div>

                </div>

            </div>
        </section>


        <section class="map mt-2">
            <div class="container-fluid p-0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15842.647593887386!2d107.45339371215643!3d-6.930953939101659!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68faa6e3c695a5%3A0xb8360e42309bb312!2sMekarmukti%2C%20Kec.%20Cihampelas%2C%20Kabupaten%20Bandung%20Barat%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1721359750373!5m2!1sid!2sid"
                    frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            </div>
        </section>

    </main>

@endsection
