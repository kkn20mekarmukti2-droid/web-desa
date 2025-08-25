@extends('layout.app')
@section('judul', 'Data Siswa Desa Mekarmukti')
@section('nav', 'data')
@section('content')

    <main id="main">

        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Data Siswa </h2>
                    <ol>
                        <li><a href="{{route('home')}}">Beranda</a></li>
                        <li>Data Jumlah Siswa</li>
                    </ol>
                </div>

            </div>
        </section>

        <section class="features">
            <div class="container">
                <div class="section-title">
                    <h2>Statistik Data Siswa Desa Mekarmukti</h2>
                    <p>Berdasarkan kondisi saat ini dan tantangan yang akan

                        dihadapi dalam enam tahun mendatang serta dengan mempertimbangkan modal dasar yang dimiliki,
                        gambaran dari
                        masalah dan potensi yang ada di Desa Mekarmukti serta keinginan yang harus terbukti dimasa enam
                        tahun kedepan
                        agar tujuan dan sasaran yang ingin dicapai dapat terukur dan terkendali.
                    </p>
                </div>



                <div class="penduduk">
                    <div class="container">
                        <div class="card sm:m-5">
                            <div class="card-header">
                                Statistik Data
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> Data Siswa Sekolah</h5>
                                <p class="card-text"></p>
                                <div>
                                    <canvas id="myChart"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>

                    <script>
                        const ctx = document.getElementById('myChart').getContext('2d');

                        function randomRgb(warna) {
                            const colors = [];

                            for (let i = 0; i < warna; i++) {
                                const r = Math.floor(Math.random() * 256);
                                const g = Math.floor(Math.random() * 256);
                                const b = Math.floor(Math.random() * 256);
                                colors.push(`rgb(${r}, ${g}, ${b})`);
                            }

                            return colors;
                        }
                        let Charts = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: [],
                                datasets: [{
                                    label: 'Jumlah Siswa',
                                    backgroundColor: [],
                                    borderColor: 'rgb(255, 255, 255)',
                                    data: [],
                                    hoverOffset: 30,
                                }]
                            },
                            options: {}
                        });

                        function updateChart() {
                            fetch('{{ route('getdatades', ['type' => 'siswa']) }}')
                                .then(response => response.json())
                                .then(data => {
                                    Charts.data.labels = data.labels;
                                    Charts.data.datasets[0].data = data.data;
                                    if (Charts.data.datasets[0].backgroundColor.length === 0) {
                                        Charts.data.datasets[0].backgroundColor = randomRgb(data.labels.length);
                                    }
                                    Charts.update();
                                })
                                .catch(error => console.error('Error fetching data:', error));
                        }

                        setInterval(updateChart, 10000);

                        updateChart();
                    </script>
                </div>
            </div>
        </section>
    </main>
@endsection
