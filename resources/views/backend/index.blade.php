@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <!-- Dashboard Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="text-dark font-weight-bold mb-0">Dashboard</h2>
                        <p class="text-muted">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your furniture store today.</p>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-2">Total Revenue</p>
                                        <h3 class="mb-0 text-dark font-weight-bold">PKR {{ number_format($totalRevenue ?? 0, 2) }}</h3>
                                        {{-- @if(isset($revenueChange))
                                            <small class="{{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                                                <i class="mdi mdi-arrow-{{ $revenueChange >= 0 ? 'up' : 'down' }}"></i> 
                                                {{ abs($revenueChange) }}% from last month
                                            </small>
                                        @endif --}}
                                    </div>
                                    <div class="icon-md bg-primary text-white rounded-circle px-2 py-1">
                                        <i class="mdi mdi-currency-usd"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-2">Total Orders</p>
                                        <h3 class="mb-0 text-dark font-weight-bold">{{ number_format($totalOrders ?? 0) }}</h3>
                                        <div class="mt-1">
                                            <small class="text-muted">{{ $completedOrders ?? 0 }} completed</small>
                                        </div>
                                    </div>
                                    <div class="icon-md bg-success text-white rounded-circle px-2 py-1">
                                        <i class="mdi mdi-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-2">Total Products</p>
                                        <h3 class="mb-0 text-dark font-weight-bold">{{ number_format($totalProducts ?? 0) }}</h3>
                                        {{-- <small class="{{ ($productChange ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="mdi mdi-arrow-{{ ($productChange ?? 0) >= 0 ? 'up' : 'down' }}"></i> 
                                            {{ abs($productChange ?? 0) }}% from last month
                                        </small> --}}
                                        <div class="mt-1">
                                            <small class="text-muted">{{ $activeProducts ?? 0 }} active</small>
                                        </div>
                                    </div>
                                    <div class="icon-md bg-info text-white rounded-circle px-2 py-1">
                                        <i class="mdi mdi-package-variant"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-2">Total Categories</p>
                                        <h3 class="mb-0 text-dark font-weight-bold">{{ number_format($totalCategories ?? 0) }}</h3>
                                        {{-- <small class="{{ ($categoryChange ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="mdi mdi-arrow-{{ ($categoryChange ?? 0) >= 0 ? 'up' : 'down' }}"></i> 
                                            {{ abs($categoryChange ?? 0) }}% from last month
                                        </small> --}}
                                        <div class="mt-1">
                                            <small class="text-muted">{{ $activeCategories ?? 0 }} active</small>
                                        </div>
                                    </div>
                                    <div class="icon-md bg-warning text-white rounded-circle px-2 py-1">
                                        <i class="mdi mdi-folder-multiple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Chart and Recent Orders -->
                <div class="row">
                    <div class="col-lg-8 grid-margin stretch-card">
                        <div class="card" style="height: 100%;">
                            <div class="card-body d-flex flex-column" style="height: 100%;">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Sales Overview</h4>
                                    <div class="dropdown">
                                        <button class="btn p-0 text-dark dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIconButton1">
                                            <a class="dropdown-item" href="#">Last 7 days</a>
                                            <a class="dropdown-item" href="#">Last 30 days</a>
                                            <a class="dropdown-item" href="#">Last 3 months</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1" style="position: relative; height: 0; min-height: 300px;">
                                    <canvas id="sales-chart" style="height: 100%; width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 grid-margin stretch-card">
                        <div class="card" style="height: 100%;">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Order Status</h4>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Pending</span>
                                        <span class="text-dark font-weight-bold">{{ $pendingOrders ?? 0 }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pendingPercentage ?? 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Processing</span>
                                        <span class="text-dark font-weight-bold">{{ $processingOrders ?? 0 }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $processingPercentage ?? 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Completed</span>
                                        <span class="text-dark font-weight-bold">{{ $completedOrders ?? 0 }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completedPercentage ?? 0 }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Cancelled</span>
                                        <span class="text-dark font-weight-bold">{{ $cancelledOrders ?? 0 }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $cancelledPercentage ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders and Top Products -->
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Recent Orders</h4>
                                    <a href="{{ route('admin.orders.index') }}" class="text-primary">View All</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Items</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentOrders ?? [] as $order)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary">
                                                            {{ $order->order_number }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong>
                                                        <br><small class="text-muted">{{ $order->email }}</small>
                                                    </td>
                                                    <td>
                                                        @if($order->items->count() > 0)
                                                            {{ $order->items->count() }} item(s)
                                                            <br><small class="text-muted">
                                                                {{ $order->items->first()->product->name ?? 'N/A' }}
                                                                @if($order->items->count() > 1)
                                                                    +{{ $order->items->count() - 1 }} more
                                                                @endif
                                                            </small>
                                                        @else
                                                            <span class="text-muted">No items</span>
                                                        @endif
                                                    </td>
                                                    <td><strong>PKR {{ number_format($order->total, 2) }}</strong></td>
                                                    <td>
                                                        @if($order->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($order->status == 'processing')
                                                            <span class="badge badge-info">Processing</span>
                                                        @elseif($order->status == 'completed')
                                                            <span class="badge badge-success">Completed</span>
                                                        @elseif($order->status == 'cancelled')
                                                            <span class="badge badge-danger">Cancelled</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $order->created_at->format('M d, Y') }}
                                                        <br><small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        <i class="mdi mdi-information-outline"></i> No orders yet
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wait for DOM and Chart.js to be ready
        (function() {
            function initSalesChart() {
                var salesChartCanvas = document.getElementById('sales-chart');
                if (salesChartCanvas && typeof Chart !== 'undefined') {
                    var ctx = salesChartCanvas.getContext('2d');
                    
                    // Destroy existing chart if it exists
                    if (window.salesChartInstance) {
                        window.salesChartInstance.destroy();
                    }
                    
                    var salesLabels = {!! json_encode($salesLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!};
                    var salesData = {!! json_encode($salesData ?? [0, 0, 0, 0, 0, 0, 0]) !!};
                    
                    window.salesChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: salesLabels,
                            datasets: [{
                                label: 'Sales (PKR)',
                                data: salesData,
                                borderColor: '#4c84ff',
                                backgroundColor: 'rgba(76, 132, 255, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                lineTension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            aspectRatio: 2,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {
                                            return 'PKR ' + value.toFixed(2);
                                        }
                                    },
                                    gridLines: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    }
                                }]
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return 'Sales: PKR ' + tooltipItem.yLabel.toFixed(2);
                                    }
                                }
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            }
                        }
                    });
                } else if (!salesChartCanvas) {
                    console.error('Canvas element #sales-chart not found');
                } else if (typeof Chart === 'undefined') {
                    console.error('Chart.js library not loaded');
                }
            }
            
            // Try to initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(initSalesChart, 200);
                });
            } else {
                // DOM is already ready
                setTimeout(initSalesChart, 200);
            }
        })();
    </script>
@endsection
