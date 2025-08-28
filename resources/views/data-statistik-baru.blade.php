@extends('layout.app')
@section('judul', 'Data Statistik Desa Mekarmukti')
@section('nav', 'data')
@section('content')

<main id="main">
    <!-- Breadcrumb Section -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Data Statistik</h2>
                <ol>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li>Data Statistik</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="py-5 bg-gradient-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">📊 Data Statistik Penduduk</h1>
                    <p class="lead mb-0">Statistik lengkap penduduk Desa Mekarmukti berdasarkan jenis kelamin, agama, dan pekerjaan. Data dikelola secara real-time melalui sistem administrasi desa.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-chart-pie fa-8x opacity-50"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Summary -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-primary mb-2">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-primary" id="totalPenduduk">-</h3>
                            <p class="mb-0 text-muted">Total Penduduk</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-success mb-2">
                                <i class="fas fa-male fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-success" id="totalLakiLaki">-</h3>
                            <p class="mb-0 text-muted">Laki-laki</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-danger mb-2">
                                <i class="fas fa-female fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-danger" id="totalPerempuan">-</h3>
                            <p class="mb-0 text-muted">Perempuan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-warning mb-2">
                                <i class="fas fa-briefcase fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-warning" id="totalPekerja">-</h3>
                            <p class="mb-0 text-muted">Total Pekerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Chart 1: Jenis Kelamin -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-venus-mars me-2"></i>
                                <h5 class="mb-0">Berdasarkan Jenis Kelamin</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="chartJenisKelamin"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Agama -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-pray me-2"></i>
                                <h5 class="mb-0">Berdasarkan Agama</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="chartAgama"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 3: Pekerjaan -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-warning text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-briefcase me-2"></i>
                                <h5 class="mb-0">Berdasarkan Pekerjaan</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="chartPekerjaan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </section>

    <!-- RT, RW, dan KK Statistics Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">📍 Data Wilayah & Keluarga</h2>
                <p class="text-muted">Informasi RT, RW, dan Kartu Keluarga di Desa</p>
            </div>
            
            <div class="row g-4">
                <!-- Total RT -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-2">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                            </div>
                            <h3 class="fw-bold" id="totalRT">-</h3>
                            <p class="mb-0 small opacity-75">Total RT</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total RW -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 bg-gradient" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-2">
                                <i class="fas fa-home fa-2x"></i>
                            </div>
                            <h3 class="fw-bold" id="totalRW">-</h3>
                            <p class="mb-0 small opacity-75">Total RW</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total Penduduk RT/RW -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 bg-gradient" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-2">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h3 class="fw-bold" id="totalPendudukRTRW">-</h3>
                            <p class="mb-0 small opacity-75">Penduduk RT/RW</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total KK -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 bg-gradient" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-2">
                                <i class="fas fa-id-card fa-2x"></i>
                            </div>
                            <h3 class="fw-bold" id="totalKK">-</h3>
                            <p class="mb-0 small opacity-75">Total KK</p>
                        </div>
                    </div>
                </div>
                
                <!-- KK Kepala Laki-laki -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 bg-gradient" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-2">
                                <i class="fas fa-male fa-2x"></i>
                            </div>
                            <h3 class="fw-bold" id="totalKKLaki">-</h3>
                            <p class="mb-0 small opacity-75">KK Kepala ♂</p>
                        </div>
                    </div>
                </div>
                
                <!-- KK Kepala Perempuan -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 bg-gradient" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-2">
                                <i class="fas fa-female fa-2x"></i>
                            </div>
                            <h3 class="fw-bold" id="totalKKPerempuan">-</h3>
                            <p class="mb-0 small opacity-75">KK Kepala ♀</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detail RT/RW Cards -->
            <div class="row g-4 mt-4">
                <div class="col-12">
                    <h4 class="fw-bold text-center mb-4">📍 Detail per RT & RW</h4>
                </div>
                
                <!-- RT Details -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-map-pin me-2"></i>Data per RT</h5>
                        </div>
                        <div class="card-body">
                            <div id="rtDetails" class="row g-3">
                                <!-- RT data will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- RW Details -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-home me-2"></i>Data per RW</h5>
                        </div>
                        <div class="card-body">
                            <div id="rwDetails" class="row g-3">
                                <!-- RW data will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Info Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h3 class="mb-4">📈 Data Real-Time</h3>
                    <p class="lead text-muted">Data statistik ini dikelola secara real-time oleh perangkat desa dan diperbarui sesuai dengan kondisi terkini. Untuk informasi lebih detail atau pertanyaan mengenai data statistik, silakan hubungi kantor desa.</p>
                    
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="text-primary mb-2">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Update Real-Time</h6>
                            <p class="small text-muted">Data diperbarui setiap hari</p>
                        </div>
                        <div class="col-md-4">
                            <div class="text-success mb-2">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Data Terpercaya</h6>
                            <p class="small text-muted">Dikelola oleh perangkat desa</p>
                        </div>
                        <div class="col-md-4">
                            <div class="text-warning mb-2">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Visualisasi Interaktif</h6>
                            <p class="small text-muted">Chart interaktif dan responsif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
// Modern Chart Configuration
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 12;

// Color Palettes
const colorSchemes = {
    jenis_kelamin: {
        colors: ['#3B82F6', '#EC4899'],
        labels: ['Laki-laki', 'Perempuan']
    },
    agama: {
        colors: ['#10B981', '#F59E0B', '#8B5CF6', '#EF4444', '#6B7280', '#F97316'],
        labels: []
    },
    pekerjaan: {
        colors: ['#059669', '#DC2626', '#7C3AED', '#EA580C', '#6366F1', '#BE123C', '#0891B2', '#CA8A04'],
        labels: []
    }
};

// Create Enhanced Chart
function createModernChart(ctx, type, colors) {
    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                label: 'Jumlah',
                data: [],
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 5,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#374151',
                    borderWidth: 1,
                    cornerRadius: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const value = Number(context.parsed) || Number(context.raw) || 0;
                            const dataset = context.dataset.data;
                            const total = dataset.reduce((a, b) => (Number(a) || 0) + (Number(b) || 0), 0);
                            
                            if (total === 0) {
                                return context.label + ': ' + value.toLocaleString() + ' jiwa (0%)';
                            }
                            
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': ' + value.toLocaleString() + ' jiwa (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            cutout: '50%'
        }
    });
}

// Update Chart Function
function updateChart(chart, endpoint, summaryElementId = null) {
    console.log('🔄 Updating chart from:', endpoint);
    
    fetch(endpoint)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Chart data received:', data);
            
            const labels = data.labels || [];
            const values = (data.data || []).map(val => {
                const num = Number(val);
                return isNaN(num) ? 0 : num;
            });
            
            console.log('📊 Processed data:', { labels, values });
            
            // Update chart
            chart.data.labels = labels;
            chart.data.datasets[0].data = values;
            chart.update('active');
            
            // Update summary if provided
            if (summaryElementId) {
                const total = values.reduce((a, b) => a + b, 0);
                const element = document.getElementById(summaryElementId);
                if (element) {
                    element.textContent = total.toLocaleString();
                }
            }
            
            // Update specific counters for jenis kelamin
            if (labels.includes('Laki-laki') && labels.includes('Perempuan')) {
                const lakiIndex = labels.indexOf('Laki-laki');
                const perempuanIndex = labels.indexOf('Perempuan');
                
                if (lakiIndex !== -1) {
                    const lakiElement = document.getElementById('totalLakiLaki');
                    if (lakiElement) lakiElement.textContent = values[lakiIndex].toLocaleString();
                }
                
                if (perempuanIndex !== -1) {
                    const perempuanElement = document.getElementById('totalPerempuan');
                    if (perempuanElement) perempuanElement.textContent = values[perempuanIndex].toLocaleString();
                }
            }
        })
        .catch(error => {
            console.error('❌ Error updating chart:', error);
            
            // Show error state
            if (summaryElementId) {
                const element = document.getElementById(summaryElementId);
                if (element) element.textContent = 'Error';
            }
        });
}

// Calculate total pekerja
function updateTotalPekerja() {
    fetch('{{ route("getdatades", ["type" => "pekerjaan"]) }}')
        .then(response => response.json())
        .then(data => {
            const values = (data.data || []).map(val => Number(val) || 0);
            const total = values.reduce((a, b) => a + b, 0);
            
            const element = document.getElementById('totalPekerja');
            if (element) element.textContent = total.toLocaleString();
        })
        .catch(error => console.error('Error updating total pekerja:', error));
}

// Initialize Charts
console.log('🚀 Initializing charts...');

const chartJenisKelamin = createModernChart(
    document.getElementById('chartJenisKelamin').getContext('2d'),
    'jenis_kelamin',
    colorSchemes.jenis_kelamin.colors
);

const chartAgama = createModernChart(
    document.getElementById('chartAgama').getContext('2d'),
    'agama',
    colorSchemes.agama.colors
);

const chartPekerjaan = createModernChart(
    document.getElementById('chartPekerjaan').getContext('2d'),
    'pekerjaan',
    colorSchemes.pekerjaan.colors
);

// Load Initial Data
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM loaded, starting data load...');
    
    setTimeout(() => {
        updateChart(chartJenisKelamin, '{{ route("getdatades", ["type" => "penduduk"]) }}', 'totalPenduduk');
    }, 300);
    
    setTimeout(() => {
        updateChart(chartAgama, '{{ route("getdatades", ["type" => "agama"]) }}');
    }, 600);
    
    setTimeout(() => {
        updateChart(chartPekerjaan, '{{ route("getdatades", ["type" => "pekerjaan"]) }}');
        updateTotalPekerja();
    }, 900);
    
    // Load RT/RW/KK stats (not charts)
    setTimeout(() => {
        updateRTRWKKStats();
    }, 1200);
});

// Function to update RT/RW/KK statistics
function updateRTRWKKStats() {
    // Load KK data
    fetch('{{ route("getdatades", ["type" => "kk"]) }}')
        .then(response => response.json())
        .then(data => {
            let totalKK = 0;
            let totalKKLaki = 0;
            let totalKKPerempuan = 0;
            
            if (data.labels && data.data) {
                for (let i = 0; i < data.labels.length; i++) {
                    const value = parseInt(data.data[i]) || 0;
                    totalKK += value;
                    
                    if (data.labels[i].toLowerCase().includes('laki')) {
                        totalKKLaki = value;
                    } else if (data.labels[i].toLowerCase().includes('perempuan')) {
                        totalKKPerempuan = value;
                    }
                }
            }
            
            document.getElementById('totalKK').textContent = totalKK.toLocaleString();
            document.getElementById('totalKKLaki').textContent = totalKKLaki.toLocaleString();
            document.getElementById('totalKKPerempuan').textContent = totalKKPerempuan.toLocaleString();
        })
        .catch(error => {
            console.error('Error loading KK data:', error);
            document.getElementById('totalKK').textContent = '0';
            document.getElementById('totalKKLaki').textContent = '0';
            document.getElementById('totalKKPerempuan').textContent = '0';
        });
    
    // Load RT/RW data
    fetch('{{ route("getdatades", ["type" => "rt_rw"]) }}')
        .then(response => response.json())
        .then(data => {
            let totalRT = 0;
            let totalRW = 0;
            let totalPendudukRTRW = 0;
            let rtData = [];
            let rwData = [];
            
            if (data.labels && data.data) {
                for (let i = 0; i < data.labels.length; i++) {
                    const label = data.labels[i];
                    const value = parseInt(data.data[i]) || 0;
                    totalPendudukRTRW += value;
                    
                    if (label.toLowerCase().includes('rt')) {
                        totalRT++;
                        rtData.push({ label: label, value: value });
                    } else if (label.toLowerCase().includes('rw')) {
                        totalRW++;
                        rwData.push({ label: label, value: value });
                    }
                }
            }
            
            document.getElementById('totalRT').textContent = totalRT;
            document.getElementById('totalRW').textContent = totalRW;
            document.getElementById('totalPendudukRTRW').textContent = totalPendudukRTRW.toLocaleString();
            
            // Populate RT details
            const rtDetailsContainer = document.getElementById('rtDetails');
            rtDetailsContainer.innerHTML = '';
            rtData.forEach(rt => {
                const rtCard = `
                    <div class="col-6">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-2">
                                <h6 class="fw-bold text-info">${rt.label}</h6>
                                <h5 class="mb-0 text-dark">${rt.value.toLocaleString()}</h5>
                                <small class="text-muted">Penduduk</small>
                            </div>
                        </div>
                    </div>
                `;
                rtDetailsContainer.innerHTML += rtCard;
            });
            
            // Populate RW details
            const rwDetailsContainer = document.getElementById('rwDetails');
            rwDetailsContainer.innerHTML = '';
            rwData.forEach(rw => {
                const rwCard = `
                    <div class="col-6">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-2">
                                <h6 class="fw-bold text-success">${rw.label}</h6>
                                <h5 class="mb-0 text-dark">${rw.value.toLocaleString()}</h5>
                                <small class="text-muted">Penduduk</small>
                            </div>
                        </div>
                    </div>
                `;
                rwDetailsContainer.innerHTML += rwCard;
            });
        })
        .catch(error => {
            console.error('Error loading RT/RW data:', error);
            document.getElementById('totalRT').textContent = '0';
            document.getElementById('totalRW').textContent = '0';
            document.getElementById('totalPendudukRTRW').textContent = '0';
        });
}

// Auto-refresh every 5 minutes
setInterval(() => {
    console.log('🔄 Auto-refreshing charts...');
    updateChart(chartJenisKelamin, '{{ route("getdatades", ["type" => "penduduk"]) }}', 'totalPenduduk');
    updateChart(chartAgama, '{{ route("getdatades", ["type" => "agama"]) }}');
    updateChart(chartPekerjaan, '{{ route("getdatades", ["type" => "pekerjaan"]) }}');
    updateTotalPekerja();
    updateRTRWKKStats();
}, 300000);
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.chart-container {
    position: relative;
    margin: auto;
}

.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.opacity-50 {
    opacity: 0.5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .chart-container {
        height: 250px !important;
    }
    
    .display-4 {
        font-size: 2rem;
    }
}
</style>

@endsection
