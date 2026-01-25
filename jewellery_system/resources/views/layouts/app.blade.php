<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewellery Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; box-shadow: 0 0 10px rgba(0,0,0,0.1); background: #fff; }
        .nav-link { color: #333; font-weight: 500; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { background-color: #f0f0f0; color: #0d6efd; border-radius: 5px; }
        .card { border: none; box-shadow: 0 0 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar d-none d-md-block">
                <div class="p-3 border-bottom">
                    <h5 class="m-0 text-primary"><i class="fas fa-gem me-2"></i>JMS Admin</h5>
                </div>
                <div class="p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}"><i class="fas fa-boxes me-2"></i>Inventory</a></li>
                        <li class="nav-item"><a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}"><i class="fas fa-tags me-2"></i>Categories</a></li>
                        <li class="nav-item"><a href="{{ route('sales.create') }}" class="nav-link {{ request()->is('sales/create') ? 'active' : '' }}"><i class="fas fa-cash-register me-2"></i>New Sale</a></li>
                        <li class="nav-item"><a href="{{ route('sales.index') }}" class="nav-link {{ request()->is('sales') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar me-2"></i>Sales History</a></li>
                        <li class="nav-item"><a href="{{ route('customers.index') }}" class="nav-link {{ request()->is('customers*') ? 'active' : '' }}"><i class="fas fa-users me-2"></i>Customers</a></li>
                        <li class="nav-item"><a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->is('suppliers*') ? 'active' : '' }}"><i class="fas fa-truck me-2"></i>Suppliers</a></li>
                        <li class="nav-item"><a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}"><i class="fas fa-chart-line me-2"></i>Reports</a></li>
                        <li class="nav-item"><a href="{{ route('settings.index') }}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-3">
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded mb-4 border d-md-none">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">JMS</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </nav>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h3">@yield('header')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
