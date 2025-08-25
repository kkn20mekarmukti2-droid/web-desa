@extends('layout.app')
@section('judul', 'Data Penduduk Desa Mekarmukti')
@section('nav', 'data')
@section('content')
<main id="main">

    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Data Penduduk</h2>
                <ol>
                    <li><a href="{{ route('home') }}">Data Desa</a></li>
                    <li>Data Penduduk</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Jumlah Penduduk Desa Mekarmukti</h2>
                <p>Berdasarkan kondisi saat ini dan tantangan yang akan dihadapi dalam enam tahun mendatang...</p>
            </div>

            <div class="row">
                <!-- Chart Penduduk -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">Statistik Data Penduduk</div>
                        <div class="card-body">
                            <canvas id="chartPenduduk"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart KK -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">Statistik Data KK</div>
                        <div class="card-body">
                            <canvas id="chartKK"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
    // Setup Chart.js Pie Chart
    function createPieChart(ctx, labels, data, colors) {
        return new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah',
                    data: data,
                    backgroundColor: colors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + context.parsed.toLocaleString() + ' orang';
                            }
                        }
                    }
                }
            }
        });
    }

    function updateChart(chart, url) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.data;
                chart.update();
            });
    }

    // Chart instances
    const chartPenduduk = createPieChart(
        document.getElementById('chartPenduduk').getContext('2d'),
        [],
        [],
        ['#36A2EB', '#FF6384']
    );

    const chartKK = createPieChart(
        document.getElementById('chartKK').getContext('2d'),
        [],
        [],
        ['#4BC0C0', '#FF9F40']
    );

    // Load data
    updateChart(chartPenduduk, '{{ route("getdatades", ["type" => "penduduk"]) }}');
    updateChart(chartKK, '{{ route("getdatades", ["type" => "kk"]) }}');
</script>
@endsection
