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
                <!-- Chart 1: Penduduk berdasarkan Jenis Kelamin -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-people-fill me-2"></i>
                            Data Penduduk berdasarkan Jenis Kelamin
                        </div>
                        <div class="card-body">
                            <canvas id="chartJenisKelamin"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Penduduk berdasarkan Agama -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <i class="bi bi-peace me-2"></i>
                            Data Penduduk berdasarkan Agama
                        </div>
                        <div class="card-body">
                            <canvas id="chartAgama"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 3: Penduduk berdasarkan Pekerjaan -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <i class="bi bi-briefcase-fill me-2"></i>
                            Data Penduduk berdasarkan Pekerjaan
                        </div>
                        <div class="card-body">
                            <canvas id="chartPekerjaan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
    // Enhanced Chart.js Configuration
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.font.size = 12;

    // Color Palettes for each chart
    const genderColors = ['#3B82F6', '#EC4899']; // Blue & Pink
    const religionColors = ['#10B981', '#F59E0B', '#8B5CF6', '#EF4444', '#6B7280']; // Green, Yellow, Purple, Red, Gray
    const jobColors = ['#059669', '#DC2626', '#7C3AED', '#EA580C', '#6366F1']; // Green, Red, Purple, Orange, Indigo (5 colors)

    // Create Enhanced Pie Chart
    function createEnhancedPieChart(ctx, colors, title) {
        return new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah',
                    data: [],
                    backgroundColor: colors,
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    hoverBorderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function (context) {
                                // Get data with proper type conversion
                                const currentValue = Number(context.parsed) || Number(context.raw) || 0;
                                const dataValues = context.dataset.data.map(val => Number(val) || 0);
                                const total = dataValues.reduce((a, b) => a + b, 0);
                                
                                if (total === 0) {
                                    return context.label + ': ' + currentValue.toLocaleString() + ' jiwa (0%)';
                                }
                                
                                const percentage = ((currentValue / total) * 100).toFixed(1);
                                return context.label + ': ' + currentValue.toLocaleString() + ' jiwa (' + percentage + '%)';
                            }
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    function updateChart(chart, url, totalElementId) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                console.log('Chart data received:', data); // Debug log
                
                // Ensure data is properly converted to numbers
                const labels = data.labels || [];
                const values = (data.data || []).map(val => {
                    const num = Number(val);
                    return isNaN(num) ? 0 : num;
                });
                
                console.log('Processed values:', values); // Debug log
                
                chart.data.labels = labels;
                chart.data.datasets[0].data = values;
                chart.update('active');
                
                // Update total counter (if element exists)
                if (totalElementId && document.getElementById(totalElementId)) {
                    const total = values.reduce((a, b) => a + b, 0);
                    document.getElementById(totalElementId).textContent = total.toLocaleString();
                }
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                // Show error state
                if (totalElementId && document.getElementById(totalElementId)) {
                    document.getElementById(totalElementId).textContent = 'Error';
                }
            });
    }

    // Initialize Charts
    const chartJenisKelamin = createEnhancedPieChart(
        document.getElementById('chartJenisKelamin').getContext('2d'),
        genderColors,
        'Jenis Kelamin'
    );

    const chartAgama = createEnhancedPieChart(
        document.getElementById('chartAgama').getContext('2d'),
        religionColors,
        'Agama'
    );

    const chartPekerjaan = createEnhancedPieChart(
        document.getElementById('chartPekerjaan').getContext('2d'),
        jobColors,
        'Pekerjaan'
    );

    // Load Data with staggered animation
    setTimeout(() => updateChart(chartJenisKelamin, '{{ route("getdatades", ["type" => "penduduk"]) }}', 'totalJenisKelamin'), 200);
    setTimeout(() => updateChart(chartAgama, '{{ route("getdatades", ["type" => "agama"]) }}', 'totalAgama'), 500);
    setTimeout(() => updateChart(chartPekerjaan, '{{ route("getdatades", ["type" => "pekerjaan"]) }}'), 800);

    // Auto refresh every 30 seconds
    setInterval(() => {
        updateChart(chartJenisKelamin, '{{ route("getdatades", ["type" => "penduduk"]) }}', 'totalJenisKelamin');
        updateChart(chartAgama, '{{ route("getdatades", ["type" => "agama"]) }}', 'totalAgama');
        updateChart(chartPekerjaan, '{{ route("getdatades", ["type" => "pekerjaan"]) }}');
    }, 30000);
</script>
@endsection
