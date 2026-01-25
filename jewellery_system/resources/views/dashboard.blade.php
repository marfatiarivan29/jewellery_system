@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Items</h6>
                        <h2 class="my-2 fw-bold">{{ $totalItems }}</h2>
                    </div>
                    <i class="fas fa-gem fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Sales</h6>
                        <h2 class="my-2 fw-bold">{{ $totalSales }}</h2>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Customers</h6>
                        <h2 class="my-2 fw-bold">{{ $totalCustomers }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Low Stock</h6>
                        <h2 class="my-2 fw-bold">{{ $lowStockItems->count() }}</h2>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Low Stock -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Sales Overview (Last 7 Days)</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-danger">Low Stock Alerts</h5>
                <span class="badge bg-danger rounded-pill">{{ $lowStockItems->count() }}</span>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($lowStockItems->take(5) as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item->name }}</strong>
                            <br><small class="text-muted">{{ $item->category->name }}</small>
                        </div>
                        <span class="badge bg-soft-danger text-danger border border-danger rounded-pill">{{ $item->stock_quantity }} Left</span>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted py-3">Everything is well stocked!</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Available Products Grid -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold text-secondary">Latest Jewellery Collection</h4>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add New Item</a>
</div>

<div class="row g-4">
    @forelse($products as $product)
    <div class="col-md-3 col-sm-6">
        <div class="card h-100 shadow-sm border-0 product-card">
            <div class="position-relative">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                    </div>
                @endif
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-white text-dark shadow-sm">{{ $product->metal_type }} {{ $product->purity }}</span>
                </div>
            </div>
            <div class="card-body">
                <h6 class="card-title fw-bold text-truncate">{{ $product->name }}</h6>
                <p class="card-text text-muted small mb-2">{{ $product->category->name }} | {{ $product->weight }}g</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0 text-primary">₹{{ number_format($product->price) }}</span>
                    <small class="text-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </small>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-grid">
                    <a href="{{ route('sales.create') }}" class="btn btn-outline-dark btn-sm rounded-pill">
                        <i class="fas fa-shopping-cart me-2"></i>Quick Sell
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            No products added yet. <a href="{{ route('products.create') }}" class="alert-link">Add your first item!</a>
        </div>
    </div>
    @endforelse
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Sales (₹)',
                data: @json($dailySales),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
<style>
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .product-card { transition: transform 0.2s; }
    .product-card:hover { transform: translateY(-5px); }
</style>
@endpush
@endsection
