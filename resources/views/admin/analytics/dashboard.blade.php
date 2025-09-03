@extends('layout.admin')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-chart-line me-2 text-primary"></i>
            Analytics Dashboard
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshStats()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pengunjung Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold" id="card-visitors-today">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pengunjung</div>
                            <div class="h5 mb-0 font-weight-bold" id="card-visitors-total">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Online Sekarang</div>
                            <div class="h5 mb-0 font-weight-bold" id="card-visitors-online">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Halaman Dilihat</div>
                            <div class="h5 mb-0 font-weight-bold" id="card-page-views">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 7 Days Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-area me-2"></i>
                        Statistik 7 Hari Terakhir
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="sevenDaysChart" width="100%" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Pages -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star me-2"></i>
                        Halaman Populer
                    </h6>
                </div>
                <div class="card-body">
                    <div id="popular-pages-list">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Browser Statistics -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fab fa-chrome me-2"></i>
                        Browser Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="browserChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Device Statistics -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-mobile-alt me-2"></i>
                        Device Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="deviceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let sevenDaysChart, browserChart, deviceChart;
    
    // Initialize analytics dashboard
    loadDashboardData();
    
    // Auto refresh every 60 seconds
    setInterval(loadDashboardData, 60000);
    
    function loadDashboardData() {
        fetch('/api/visitor-dashboard', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatsCards(data.data.current_stats);
                updateSevenDaysChart(data.data.last_7_days);
                updatePopularPages(data.data.popular_pages);
                updateBrowserChart(data.data.browser_stats);
                updateDeviceChart(data.data.device_stats);
            }
        })
        .catch(error => {
            console.error('Error loading dashboard data:', error);
        });
    }
    
    function updateStatsCards(stats) {
        document.getElementById('card-visitors-today').textContent = formatNumber(stats.today.total);
        document.getElementById('card-visitors-total').textContent = formatNumber(stats.all_time.total);
        document.getElementById('card-visitors-online').textContent = formatNumber(stats.online_now);
        document.getElementById('card-page-views').textContent = formatNumber(stats.today.page_views);
    }
    
    function updateSevenDaysChart(data) {
        const ctx = document.getElementById('sevenDaysChart').getContext('2d');
        
        if (sevenDaysChart) {
            sevenDaysChart.destroy();
        }
        
        const labels = data.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
        });
        
        sevenDaysChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pengunjung',
                    data: data.map(item => item.total_visitors),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Pengunjung Unik',
                    data: data.map(item => item.unique_visitors),
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    function updatePopularPages(pages) {
        const container = document.getElementById('popular-pages-list');
        
        if (pages.length === 0) {
            container.innerHTML = '<p class="text-muted text-center">Belum ada data halaman populer</p>';
            return;
        }
        
        let html = '';
        pages.forEach((page, index) => {
            const percentage = pages[0].visit_count > 0 ? (page.visit_count / pages[0].visit_count * 100) : 0;
            html += `
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-sm">${page.page_title || 'Unknown Page'}</span>
                        <span class="text-sm text-muted">${page.visit_count} views</span>
                    </div>
                    <div class="progress mt-1" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" 
                             style="width: ${percentage}%" aria-valuenow="${percentage}" 
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }
    
    function updateBrowserChart(data) {
        const ctx = document.getElementById('browserChart').getContext('2d');
        
        if (browserChart) {
            browserChart.destroy();
        }
        
        if (data.length === 0) return;
        
        browserChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.map(item => item.browser),
                datasets: [{
                    data: data.map(item => item.count),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02d1b'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    function updateDeviceChart(data) {
        const ctx = document.getElementById('deviceChart').getContext('2d');
        
        if (deviceChart) {
            deviceChart.destroy();
        }
        
        if (data.length === 0) return;
        
        deviceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.map(item => item.device),
                datasets: [{
                    data: data.map(item => item.count),
                    backgroundColor: [
                        '#1cc88a', '#36b9cc', '#f6c23e'
                    ],
                    hoverBackgroundColor: [
                        '#17a673', '#2c9faf', '#f4b619'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }
    
    // Global refresh function
    window.refreshStats = function() {
        loadDashboardData();
        // Show refresh feedback
        const refreshBtn = document.querySelector('button[onclick="refreshStats()"]');
        const icon = refreshBtn.querySelector('i');
        icon.classList.add('fa-spin');
        setTimeout(() => {
            icon.classList.remove('fa-spin');
        }, 1000);
    };
});
</script>
@endpush
