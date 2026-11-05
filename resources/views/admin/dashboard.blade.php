<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - Kantin Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --admin-primary: #3b82f6;
            --admin-secondary: #64748b;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-dark: #1e293b;
            --admin-light: #f8fafc;
        }
        
        body {
            background-color: var(--admin-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, var(--admin-primary), #1e40af);
            min-height: 100vh;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .main-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .recent-activity {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .activity-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s ease;
        }
        
        .activity-item:hover {
            background: #f8fafc;
            margin: 0 -12px;
            padding: 12px;
            border-radius: 8px;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .badge-status {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-success));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .btn-admin {
            background: var(--admin-primary);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .table-modern {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .table-modern thead {
            background: #f8fafc;
        }
        
        .table-modern th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            color: var(--admin-dark);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table-modern td {
            padding: 1rem;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        
        .table-modern tbody tr:hover {
            background: #f8fafc;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                width: 250px;
                z-index: 1000;
                transition: left 0.3s ease;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-none d-lg-block" style="width: 250px; position: fixed; left: 0; top: 0; z-index: 100;">
        <div class="p-4">
            <div class="d-flex align-items-center mb-4">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg d-flex align-items-center justify-center me-3">
                    <i class="fas fa-user-shield text-white"></i>
                </div>
                <div>
                    <h4 class="text-white mb-0">Admin Panel</h4>
                    <small class="text-white opacity-75">Kantin Digital</small>
                </div>
            </div>
        </div>
        
        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link">
                <i class="fas fa-utensils"></i> Menu Produk
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-shopping-cart"></i> Transaksi
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-users"></i> Siswa
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </nav>
        
        <div class="mt-auto p-4">
            <div class="border-top border-white border-opacity-25 pt-3">
                <div class="d-flex align-items-center text-white mb-3">
                    <div class="user-avatar me-3">
                        {{ auth()->user()->name[0] ?? 'A' }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <small class="opacity-75">Administrator</small>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" style="margin-left: 250px;">
        <!-- Header -->
        <header class="main-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <button class="btn btn-link d-lg-none" type="button" id="sidebarToggle">
                            <i class="fas fa-bars fs-4"></i>
                        </button>
                        <h2 class="h4 mb-0 fw-bold">Dashboard</h2>
                        <p class="text-muted mb-0">Selamat datang di panel administrasi</p>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div class="position-relative">
                                <button class="btn btn-light position-relative">
                                    <i class="fas fa-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </button>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                    <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                        {{ auth()->user()->name[0] ?? 'A' }}
                                    </div>
                                    <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content Area -->
        <main class="p-4">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3 class="h2 mb-1 fw-bold">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-muted mb-0">Penjualan Hari Ini</p>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>12% dari kemarin</small>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="h2 mb-1 fw-bold">{{ $todayTransactions ?? 0 }}</h3>
                        <p class="text-muted mb-0">Transaksi Hari Ini</p>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>8% dari kemarin</small>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="h2 mb-1 fw-bold">{{ $totalProducts ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Produk</p>
                        <small class="text-info">{{ $activeProducts ?? 0 }} aktif</small>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h2 mb-1 fw-bold">{{ $totalStudents ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Siswa</p>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>5% bulan ini</small>
                    </div>
                </div>
            </div>
            
            <!-- Charts and Tables Row -->
            <div class="row g-4 mb-4">
                <!-- Sales Chart -->
                <div class="col-lg-8">
                    <div class="chart-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-bold">Grafik Penjualan</h5>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary active">7 Hari</button>
                                <button type="button" class="btn btn-outline-primary">30 Hari</button>
                                <button type="button" class="btn btn-outline-primary">3 Bulan</button>
                            </div>
                        </div>
                        <canvas id="salesChart" height="100"></canvas>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="col-lg-4">
                    <div class="chart-container">
                        <h5 class="mb-4 fw-bold">Aksi Cepat</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-admin">
                                <i class="fas fa-plus me-2"></i>Tambah Produk Baru
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                                <i class="fas fa-tags me-2"></i>Tambah Kategori
                            </a>
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="fas fa-download me-2"></i>Export Laporan
                            </a>
                            <a href="#" class="btn btn-outline-info">
                                <i class="fas fa-sync me-2"></i>Sync Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="row g-4">
                <!-- Recent Transactions -->
                <div class="col-lg-6">
                    <div class="recent-activity">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-bold">Transaksi Terakhir</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                        <div class="activity-list">
                            @forelse ($recentTransactions ?? [] as $transaction)
                                <div class="activity-item">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                            {{ $transaction->user->name[0] ?? 'U' }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $transaction->user->name ?? 'Unknown' }}</div>
                                            <small class="text-muted">{{ $transaction->created_at->format('H:i') }} • {{ $transaction->items->count() }} item</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-primary">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</div>
                                            <span class="badge-status bg-success">Paid</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fs-1 mb-3 d-block"></i>
                                    Belum ada transaksi hari ini
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Low Stock Alert -->
                <div class="col-lg-6">
                    <div class="recent-activity">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-bold">Stok Menipis</h5>
                            <span class="badge bg-danger">{{ $lowStockProducts ?? 0 }} item</span>
                        </div>
                        <div class="activity-list">
                            @forelse ($lowStockItems ?? [] as $product)
                                <div class="activity-item">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-warning">{{ $product->stock }} pcs</div>
                                            <small class="text-muted">tersisa</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-check-circle fs-1 mb-3 d-block text-success"></i>
                                    Semua produk stok aman
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
        
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($salesChart->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M')) ?? []),
                datasets: [{
                    label: 'Penjualan',
                    data: @json($salesChart->pluck('total') ?? []),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Auto-refresh dashboard every 30 seconds
        setInterval(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-900 hover:text-school-blue px-3 py-2 text-sm font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-school-blue px-3 py-2 text-sm font-medium">
                        <i class="fas fa-utensils mr-2"></i>
                        Menu
                    </a>
                    <a href="{{ route('admin.settings') }}" class="text-gray-700 hover:text-school-blue px-3 py-2 text-sm font-medium">
                        <i class="fas fa-cog mr-2"></i>
                        Pengaturan
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Keluar
                        </button>
                    </form>
                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-700 hover:text-school-blue p-2" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-900 hover:text-school-blue hover:bg-gray-50 rounded-md">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 text-gray-700 hover:text-school-blue hover:bg-gray-50 rounded-md">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('admin.settings') }}" class="block px-3 py-2 text-gray-700 hover:text-school-blue hover:bg-gray-50 rounded-md">
                    <i class="fas fa-cog mr-2"></i>Pengaturan
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-school-blue to-school-green rounded-xl p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang, Admin!</h1>
                        <p class="opacity-90">Dashboard administrasi Kantin Digital Sekolah</p>
                    </div>
                    <div class="text-right">
                        <div class="text-5xl font-bold">{{ now()->format('H:i') }}</div>
                        <div class="text-sm opacity-75">{{ now()->format('l, d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-school-blue rounded-lg p-3">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-green-600">Hari ini</p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-school-green rounded-lg p-3">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900">Rp 0</p>
                        <p class="text-xs text-green-600">Hari ini</p>
                    </div>
                </div>
            </div>

            <!-- Active Products -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-school-orange rounded-lg p-3">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menu Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-blue-600">Total produk</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-blue-600">Terdaftar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Manage Products -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b bg-gradient-to-r from-school-blue to-blue-600">
                    <h2 class="text-xl font-semibold text-white">Kelola Menu</h2>
                    <p class="text-blue-100 text-sm mt-1">Tambah, edit, dan hapus produk</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="{{ route('admin.products.index') }}" 
                           class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-list text-school-blue mr-3"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Daftar Menu</h3>
                                    <p class="text-sm text-gray-600">Lihat semua produk</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>
                        
                        <a href="{{ route('admin.products.create') }}" 
                           class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-plus text-school-green mr-3"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Tambah Menu</h3>
                                    <p class="text-sm text-gray-600">Tambah produk baru</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Manage Settings -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b bg-gradient-to-r from-school-green to-green-600">
                    <h2 class="text-xl font-semibold text-white">Pengaturan Toko</h2>
                    <p class="text-green-100 text-sm mt-1">Konfigurasi sistem</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="{{ route('admin.settings') }}" 
                           class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-cog text-school-blue mr-3"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Pengaturan Umum</h3>
                                    <p class="text-sm text-gray-600">Nama toko, jam operasional</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>
                        
                        <a href="#" 
                           class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-school text-school-orange mr-3"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Data Sekolah</h3>
                                    <p class="text-sm text-gray-600">Info sekolah dan kontak</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-900">Aktivitas Terbaru</h2>
            </div>
            <div class="p-6">
                <div class="text-center py-8">
                    <i class="fas fa-history text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600">Belum ada aktivitas</p>
                    <p class="text-sm text-gray-500">Aktivitas sistem akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2024 Kantin Digital. All rights reserved.</p>
                <p class="text-sm text-gray-400 mt-2">Dashboard Administrasi v1.0</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Auto refresh dashboard data
        setInterval(() => {
            // Refresh dashboard stats every 30 seconds
            location.reload();
        }, 30000);
    </script>
</body>
</html>
                    <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-utensils mr-1"></i>
                        Menu
                    </a>
                    <a href="/admin/settings" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-cog mr-1"></i>
                        Pengaturan
                    </a>
                </nav>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">
                        <i class="fas fa-user mr-1"></i>
                        {{ Auth::user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-900 hover:text-blue-600">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="/admin/settings" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
                    <i class="fas fa-cog mr-2"></i>Pengaturan
                </a>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-50 border border-green-200 rounded-md p-4 max-w-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                    <div class="mt-2 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-20 right-4 z-50 bg-red-50 border border-red-200 rounded-md p-4 max-w-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error!</h3>
                    <div class="mt-2 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-tachometer-alt text-blue-600 mr-3"></i>
                Dashboard Admin
            </h1>
            <p class="text-gray-600">Selamat datang di panel administrasi Kantin Digital</p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Menu Management -->
            <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-utensils text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Kelola Menu</h3>
                        <p class="text-sm text-gray-600">Tambah, edit, hapus menu</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-blue-600">
                    <span class="text-sm font-medium">Buka Menu</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Settings -->
            <a href="/admin/settings" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <i class="fas fa-cog text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pengaturan Toko</h3>
                        <p class="text-sm text-gray-600">Konfigurasi sistem</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-green-600">
                    <span class="text-sm font-medium">Buka Pengaturan</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <i class="fas fa-tags text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Kategori</h3>
                        <p class="text-sm text-gray-600">Kelola kategori menu</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-purple-600">
                    <span class="text-sm font-medium">Buka Kategori</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Reports -->
            <a href="{{ route('admin.reports.sales') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                        <i class="fas fa-chart-line text-orange-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Laporan</h3>
                        <p class="text-sm text-gray-600">Analytics & laporan</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-orange-600">
                    <span class="text-sm font-medium">Buka Laporan</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Today Sales -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Penjualan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-money-bill-wave text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 font-medium">0 transaksi</span>
                </div>
            </div>

            <!-- Active Products -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menu Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ App\Models\Product::available()->count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-utensils text-green-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 font-medium">Total {{ App\Models\Product::count() }} menu</span>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Stok Menipis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ App\Models\Product::lowStock()->count() }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if(App\Models\Product::lowStock()->count() > 0)
                        <span class="text-red-600 font-medium">Perlu ditambah</span>
                    @else
                        <span class="text-green-600 font-medium">Stok aman</span>
                    @endif
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900">{{ App\Models\User::siswa()->active()->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-purple-600 font-medium">Aktif hari ini</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
                </div>
                <div class="p-6">
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600">Belum ada pesanan hari ini</p>
                        <a href="{{ route('admin.reports.transactions') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                            Lihat semua pesanan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Link Cepat</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.products.create') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-plus text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-blue-900">Tambah Menu</span>
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <i class="fas fa-plus text-purple-600 mr-2"></i>
                            <span class="text-sm font-medium text-purple-900">Tambah Kategori</span>
                        </a>
                        <a href="{{ route('admin.reports.inventory') }}" class="flex items-center p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <i class="fas fa-boxes text-orange-600 mr-2"></i>
                            <span class="text-sm font-medium text-orange-900">Stok</span>
                        </a>
                        <a href="{{ route('admin.topups.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-money-check text-green-600 mr-2"></i>
                            <span class="text-sm font-medium text-green-900">Topup</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Auto hide notifications
        setTimeout(() => {
            const notifications = document.querySelectorAll('.fixed.top-20');
            notifications.forEach(notification => {
                notification.remove();
            });
        }, 5000);
    </script>
</body>
</html>
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-utensils w-5 mr-3"></i>
                        Menu Produk
                    </a>
                    
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-receipt w-5 mr-3"></i>
                        Transaksi
                    </a>
                    
                    <a href="{{ route('admin.topups.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-wallet w-5 mr-3"></i>
                        Top Up Saldo
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-users w-5 mr-3"></i>
                        Pengguna
                    </a>
                    
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Pengaturan
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-64 p-4 border-t">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                <p class="text-gray-600 mt-2">Selamat datang di panel administrasi Kantin Digital</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Siswa</p>
                            <p class="text-2xl font-bold text-gray-800">{{ App\Models\User::where('role', 'siswa')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-800">{{ App\Models\Transaction::whereDate('created_at', today())->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Omset Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format(App\Models\Transaction::whereDate('created_at', today())->sum('total_amount'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ App\Models\Product::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Transaksi Terbaru</h2>
                </div>
                <div class="p-6">
                    @if ($recentTransactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4 text-gray-600">ID</th>
                                        <th class="text-left py-3 px-4 text-gray-600">Siswa</th>
                                        <th class="text-left py-3 px-4 text-gray-600">Total</th>
                                        <th class="text-left py-3 px-4 text-gray-600">Status</th>
                                        <th class="text-left py-3 px-4 text-gray-600">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentTransactions as $transaction)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">#{{ $transaction->id }}</td>
                                        <td class="py-3 px-4">{{ $transaction->user->name }}</td>
                                        <td class="py-3 px-4">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($transaction->status == 'completed') bg-green-100 text-green-800
                                                @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada transaksi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
