{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Dashboard - Natural Vertex ERP')
@section('page-title', 'Dashboard')

@section('content')
<!-- ============================================
     TOP STATS CARDS - EXTRA SMALL
============================================ -->
<div class="row g-1 mb-2">
    <div class="col-xl-3 col-lg-6 col-md-6 col-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-body">
                <div class="stat-card-left">
                    <span class="stat-label">Today's Sales</span>
                    <h4 class="stat-value">৳ {{ number_format($stats['today_sales'] ?? 0, 2) }}</h4>
                    <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 12.5%</span>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-6">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-body">
                <div class="stat-card-left">
                    <span class="stat-label">Today's Expense</span>
                    <h4 class="stat-value">৳ {{ number_format($stats['today_expense'] ?? 0, 2) }}</h4>
                    <span class="stat-trend down"><i class="fas fa-arrow-up"></i> 8.3%</span>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-6">
        <div class="stat-card stat-card-info">
            <div class="stat-card-body">
                <div class="stat-card-left">
                    <span class="stat-label">Today's Collection</span>
                    <h4 class="stat-value">৳ {{ number_format($stats['today_collection'] ?? 0, 2) }}</h4>
                    <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 5.2%</span>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-6">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-body">
                <div class="stat-card-left">
                    <span class="stat-label">Stock Value</span>
                    <h4 class="stat-value">৳ {{ number_format($stats['current_stock_value'] ?? 0, 2) }}</h4>
                    <span class="stat-trend neutral">{{ $stats['low_stock_products'] ?? 0 }} Low</span>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     QUICK STATS - EXTRA SMALL
============================================ -->
<div class="row g-1 mb-2">
    <div class="col-xl-2 col-lg-4 col-md-4 col-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-primary"><i class="fas fa-box"></i></div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $stats['pending_purchase'] ?? 0 }}</span>
                <span class="quick-stat-label">Pending Purchase</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-warning"><i class="fas fa-truck"></i></div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $stats['pending_delivery'] ?? 0 }}</span>
                <span class="quick-stat-label">Pending Delivery</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-success"><i class="fas fa-user-check"></i></div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $stats['employee_attendance'] ?? 0 }}</span>
                <span class="quick-stat-label">Present Today</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-info"><i class="fas fa-industry"></i></div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $stats['production_status'] ?? 0 }}</span>
                <span class="quick-stat-label">Production Running</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $stats['low_stock_products'] ?? 0 }}</span>
                <span class="quick-stat-label">Low Stock Alert</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-purple"><i class="fas fa-chart-line"></i></div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">৳ {{ number_format(($stats['today_sales'] ?? 0) - ($stats['today_expense'] ?? 0), 2) }}</span>
                <span class="quick-stat-label">Today's Profit</span>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     CHART & PRODUCTS
============================================ -->
<div class="row g-1 mb-2">
    <div class="col-xl-8 col-lg-7">
        <div class="main-card">
            <div class="main-card-header">
                <h6 class="main-card-title"><i class="fas fa-chart-line text-primary"></i> Monthly Overview</h6>
                <select class="chart-select" id="chartType">
                    <option value="monthly">Monthly</option>
                    <option value="weekly">Weekly</option>
                </select>
            </div>
            <div class="main-card-body">
                <canvas id="monthlyChart" height="240"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="main-card">
            <div class="main-card-header">
                <h6 class="main-card-title"><i class="fas fa-crown text-warning"></i> Top Products</h6>
                <span class="badge-modern">This Month</span>
            </div>
            <div class="main-card-body p-0">
                @forelse($topProducts as $product)
                    <div class="list-item">
                        <div class="list-item-info">
                            <span class="list-item-name">{{ $product->product->name ?? 'N/A' }}</span>
                            <span class="list-item-meta">{{ $product->total_quantity ?? 0 }} units</span>
                        </div>
                        <span class="list-item-rank">#{{ $loop->iteration }}</span>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <span>No products</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     RECENT ACTIVITIES
============================================ -->
<div class="row">
    <div class="col-12">
        <div class="main-card">
            <div class="main-card-header">
                <h6 class="main-card-title"><i class="fas fa-history text-info"></i> Recent Activities</h6>
                <a href="#" class="link-modern">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="main-card-body p-0">
                @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity->action == 'login' ? 'bg-success' : ($activity->action == 'logout' ? 'bg-warning' : 'bg-info') }}">
                            <i class="fas fa-{{ $activity->action == 'login' ? 'sign-in-alt' : ($activity->action == 'logout' ? 'sign-out-alt' : 'edit') }}"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">
                                <strong>{{ $activity->user->name ?? 'System' }}</strong>
                                {{ $activity->description ?? $activity->action }}
                                <span class="activity-module">in {{ $activity->module }}</span>
                            </p>
                            <span class="activity-time">
                                <i class="fas fa-clock"></i>
                                {{ $activity->created_at->diffForHumans() }}
                            </span>
                        </div>
                        @if($activity->ip_address)
                            <span class="activity-ip">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $activity->ip_address }}
                            </span>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-history"></i>
                        <span>No recent activities</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ============================================
   DASHBOARD - ULTRA SMALL & SMOOTH
============================================ */
:root {
    --primary: #6c5ce7;
    --primary-light: #a29bfe;
    --primary-dark: #4a3db8;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
    --purple: #6f42c1;
    --text-dark: #1a1a2e;
    --text-muted: #6b6b80;
    --text-light: #9898aa;
    --border-color: #eef0f3;
    --bg-light: #f8f9fc;
    --shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    --shadow-hover: 0 2px 12px rgba(0, 0, 0, 0.06);
}

/* ============================================
   STAT CARDS - ULTRA SMALL
============================================ */
.stat-card {
    background: #fff;
    border: 1px solid var(--border-color);
    padding: 8px 12px 8px;
    transition: all 0.2s ease;
}

.stat-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-1px);
}

.stat-card-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-card-left {
    flex: 1;
    min-width: 0;
}

.stat-label {
    font-size: 9px;
    font-weight: 600;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: block;
}

.stat-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    letter-spacing: -0.2px;
    line-height: 1.3;
}

.stat-trend {
    font-size: 9px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 2px;
}

.stat-trend.up { color: var(--success); }
.stat-trend.down { color: var(--danger); }
.stat-trend.neutral { color: var(--warning); }

.stat-card-icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
    margin-left: 8px;
}

.stat-card-primary .stat-card-icon {
    background: rgba(108, 92, 231, 0.08);
    color: var(--primary);
}
.stat-card-primary { border-left: 2px solid var(--primary); }

.stat-card-danger .stat-card-icon {
    background: rgba(239, 68, 68, 0.08);
    color: var(--danger);
}
.stat-card-danger { border-left: 2px solid var(--danger); }

.stat-card-info .stat-card-icon {
    background: rgba(59, 130, 246, 0.08);
    color: var(--info);
}
.stat-card-info { border-left: 2px solid var(--info); }

.stat-card-warning .stat-card-icon {
    background: rgba(245, 158, 11, 0.08);
    color: var(--warning);
}
.stat-card-warning { border-left: 2px solid var(--warning); }

/* ============================================
   QUICK STATS - ULTRA SMALL
============================================ */
.quick-stat {
    background: #fff;
    border: 1px solid var(--border-color);
    padding: 6px 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.quick-stat:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-1px);
}

.quick-stat-icon {
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: #fff;
    flex-shrink: 0;
}

.quick-stat-icon.bg-primary { background: var(--primary); }
.quick-stat-icon.bg-warning { background: var(--warning); }
.quick-stat-icon.bg-success { background: var(--success); }
.quick-stat-icon.bg-info { background: var(--info); }
.quick-stat-icon.bg-danger { background: var(--danger); }
.quick-stat-icon.bg-purple { background: var(--purple); }

.quick-stat-info {
    flex: 1;
    min-width: 0;
}

.quick-stat-value {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-dark);
    display: block;
    line-height: 1.2;
}

.quick-stat-label {
    font-size: 7px;
    color: var(--text-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

/* ============================================
   MAIN CARDS
============================================ */
.main-card {
    background: #fff;
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.main-card:hover {
    box-shadow: var(--shadow-hover);
}

.main-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    border-bottom: 1px solid var(--border-color);
}

.main-card-title {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.main-card-title i {
    font-size: 13px;
}

.main-card-body {
    padding: 12px 14px;
}

/* ============================================
   CHART SELECT
============================================ */
.chart-select {
    padding: 1px 10px;
    border: 1px solid var(--border-color);
    font-size: 10px;
    color: var(--text-muted);
    background: var(--bg-light);
    cursor: pointer;
    outline: none;
    font-family: inherit;
}

.chart-select:focus {
    border-color: var(--primary);
}

/* ============================================
   BADGE
============================================ */
.badge-modern {
    font-size: 8px;
    font-weight: 600;
    color: var(--primary);
    background: rgba(108, 92, 231, 0.06);
    padding: 1px 10px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

/* ============================================
   LIST ITEMS
============================================ */
.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 14px;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s;
}

.list-item:hover {
    background: var(--bg-light);
}

.list-item:last-child {
    border-bottom: none;
}

.list-item-info {
    flex: 1;
    min-width: 0;
}

.list-item-name {
    font-size: 11px;
    font-weight: 500;
    color: var(--text-dark);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.list-item-meta {
    font-size: 9px;
    color: var(--text-light);
}

.list-item-rank {
    font-size: 10px;
    font-weight: 700;
    color: var(--primary);
    background: rgba(108, 92, 231, 0.04);
    padding: 0 8px;
    margin-left: 8px;
    flex-shrink: 0;
}

/* ============================================
   ACTIVITY ITEMS
============================================ */
.activity-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 14px;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s;
}

.activity-item:hover {
    background: var(--bg-light);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 10px;
    flex-shrink: 0;
}

.activity-icon.bg-success { background: var(--success); }
.activity-icon.bg-warning { background: var(--warning); }
.activity-icon.bg-info { background: var(--info); }

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-text {
    font-size: 11px;
    color: var(--text-dark);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-text strong {
    font-weight: 600;
}

.activity-module {
    color: var(--text-light);
    font-size: 10px;
}

.activity-time {
    font-size: 9px;
    color: var(--text-light);
}

.activity-time i {
    margin-right: 2px;
}

.activity-ip {
    font-size: 9px;
    color: var(--text-light);
    flex-shrink: 0;
    margin-left: 4px;
}

.activity-ip i {
    margin-right: 2px;
}

/* ============================================
   EMPTY STATE
============================================ */
.empty-state {
    text-align: center;
    padding: 18px 0;
    color: var(--text-light);
}

.empty-state i {
    font-size: 20px;
    display: block;
    margin-bottom: 4px;
    color: var(--border-color);
}

.empty-state span {
    font-size: 11px;
}

/* ============================================
   LINK MODERN
============================================ */
.link-modern {
    font-size: 11px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
}

.link-modern:hover {
    color: var(--primary-dark);
    gap: 6px;
}

.link-modern i {
    font-size: 9px;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 992px) {
    .stat-value {
        font-size: 14px;
    }
    
    .stat-card {
        padding: 6px 10px;
    }
    
    .stat-card-icon {
        width: 24px;
        height: 24px;
        font-size: 11px;
    }
    
    .quick-stat-value {
        font-size: 12px;
    }
    
    .quick-stat {
        padding: 5px 8px;
    }
    
    .main-card-header {
        padding: 8px 12px;
    }
    
    .main-card-body {
        padding: 10px 12px;
    }
}

@media (max-width: 576px) {
    .stat-value {
        font-size: 12px;
    }
    
    .stat-label {
        font-size: 8px;
    }
    
    .stat-card {
        padding: 4px 8px;
    }
    
    .stat-card-icon {
        width: 20px;
        height: 20px;
        font-size: 9px;
        margin-left: 4px;
    }
    
    .stat-trend {
        font-size: 8px;
    }
    
    .quick-stat {
        padding: 4px 6px;
        flex-direction: column;
        text-align: center;
        gap: 4px;
    }
    
    .quick-stat-icon {
        width: 22px;
        height: 22px;
        font-size: 9px;
    }
    
    .quick-stat-value {
        font-size: 11px;
    }
    
    .quick-stat-label {
        font-size: 6px;
    }
    
    .activity-item {
        flex-wrap: wrap;
        gap: 2px;
        padding: 4px 10px;
    }
    
    .activity-ip {
        margin-left: 36px;
    }
    
    .list-item {
        padding: 4px 10px;
    }
    
    .main-card-header {
        padding: 6px 10px;
        flex-wrap: wrap;
        gap: 4px;
    }
    
    .main-card-body {
        padding: 8px 10px;
    }
    
    .main-card-title {
        font-size: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    var monthlySales = @json($monthlySales);
    var monthlyExpenses = @json($monthlyExpenses);
    
    var labels = [];
    var salesData = [];
    var expenseData = [];
    
    if (typeof monthlySales === 'object' && monthlySales !== null) {
        var keys = Object.keys(monthlySales);
        if (keys.length > 0) {
            labels = keys.map(function(day) { return 'Day ' + day; });
            salesData = Object.values(monthlySales);
            expenseData = Object.values(monthlyExpenses);
        }
    }
    
    if (labels.length === 0) {
        labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8', 'Day 9', 'Day 10'];
        salesData = [1200, 1500, 1800, 1400, 2000, 1600, 2200, 1900, 2100, 2500];
        expenseData = [800, 900, 1000, 850, 1100, 950, 1200, 1050, 1150, 1300];
    }
    
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    let monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sales',
                    data: salesData,
                    borderColor: '#6c5ce7',
                    backgroundColor: 'rgba(108, 92, 231, 0.04)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#6c5ce7',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1.5,
                    pointRadius: 2,
                    pointHoverRadius: 4
                },
                {
                    label: 'Expenses',
                    data: expenseData,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.04)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1.5,
                    pointRadius: 2,
                    pointHoverRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { size: 10 },
                    bodyFont: { size: 9 },
                    padding: 6,
                    cornerRadius: 2,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ৳ ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return '৳ ' + value.toLocaleString(); },
                        font: { size: 8 },
                        color: '#9898aa'
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.03)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 8 },
                        color: '#9898aa',
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            },
            interaction: { intersect: false, mode: 'index' },
            elements: { line: { tension: 0.4 } }
        }
    });

    $('#chartType').change(function() {
        var type = $(this).val();
        $.ajax({
            url: '{{ route("dashboard.chart") }}',
            data: { type: type },
            success: function(data) {
                if (data && data.labels) {
                    monthlyChart.data.labels = data.labels;
                    monthlyChart.data.datasets[0].data = data.sales || [];
                    monthlyChart.data.datasets[1].data = data.expenses || [];
                    monthlyChart.update();
                }
            },
            error: function() {
                if (type === 'weekly') {
                    monthlyChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    monthlyChart.data.datasets[0].data = [1200, 1500, 1800, 1400, 2000, 1600, 2200];
                    monthlyChart.data.datasets[1].data = [800, 900, 1000, 850, 1100, 950, 1200];
                } else {
                    monthlyChart.data.labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8', 'Day 9', 'Day 10'];
                    monthlyChart.data.datasets[0].data = [1200, 1500, 1800, 1400, 2000, 1600, 2200, 1900, 2100, 2500];
                    monthlyChart.data.datasets[1].data = [800, 900, 1000, 850, 1100, 950, 1200, 1050, 1150, 1300];
                }
                monthlyChart.update();
            }
        });
    });
});
</script>
@endpush