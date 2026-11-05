<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b-2 border-amber-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-utensils text-amber-600 text-2xl mr-2"></i>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Kantin Digital
                    </h1>
                </div>
                <nav class="hidden md:flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-amber-600 font-semibold">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-receipt mr-1"></i> Pesanan
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-box mr-1"></i> Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-tags mr-1"></i> Kategori
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-600 hover:text-red-600">
                            <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                        </button>
                    </form>
                </nav>

                <button class="md:hidden text-slate-600" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-amber-600 font-semibold">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-receipt mr-2"></i>Pesanan
                </a>
                <a href="{{ route('admin.products.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-box mr-2"></i>Produk
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-tags mr-2"></i>Kategori
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-slate-600 hover:text-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">
                <i class="fas fa-chart-line text-amber-600 mr-3"></i>
                Dashboard Penjual Kantin
            </h1>
            <p class="text-slate-600">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Today Orders -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6 hover:shadow-2xl transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-slate-500">Hari Ini</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 mb-1">
                    {{ \App\Models\Order::whereDate('created_at', today())->count() }}
                </h3>
                <p class="text-sm text-slate-600">Total Pesanan</p>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-yellow-200 p-6 hover:shadow-2xl transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-slate-500">Menunggu</span>
                </div>
                <h3 class="text-3xl font-bold text-yellow-600 mb-1">
                    {{ \App\Models\Order::where('status', 'pending')->count() }}
                </h3>
                <p class="text-sm text-slate-600">Perlu Diproses</p>
            </div>

            <!-- Today Revenue -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-green-200 p-6 hover:shadow-2xl transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-slate-500">Hari Ini</span>
                </div>
                <h3 class="text-2xl font-bold text-green-600 mb-1">
                    Rp {{ number_format(\App\Models\Order::whereDate('created_at', today())->where('status', '!=', 'cancelled')->sum('total_amount'), 0, ',', '.') }}
                </h3>
                <p class="text-sm text-slate-600">Total Pendapatan</p>
            </div>

            <!-- Total Products -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-blue-200 p-6 hover:shadow-2xl transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-slate-500">Total</span>
                </div>
                <h3 class="text-3xl font-bold text-blue-600 mb-1">
                    {{ \App\Models\Product::count() }}
                </h3>
                <p class="text-sm text-slate-600">Menu Tersedia</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-receipt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Kelola Pesanan</h3>
                        <p class="text-sm text-slate-600">Lihat & proses pesanan</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Kelola Produk</h3>
                        <p class="text-sm text-slate-600">Tambah & edit menu</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6 hover:shadow-2xl transition-all hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Kelola Kategori</h3>
                        <p class="text-sm text-slate-600">Atur kategori menu</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 overflow-hidden">
            <div class="p-6 border-b-2 border-amber-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900">
                    <i class="fas fa-clock text-amber-600 mr-2"></i>
                    Pesanan Terbaru
                </h2>
                <a href="{{ route('admin.orders.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-amber-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">No. Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100">
                        @forelse(\App\Models\Order::latest()->limit(10)->get() as $order)
                        <tr class="hover:bg-amber-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-semibold text-amber-600">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">{{ $order->customer_name }}</p>
                                <p class="text-sm text-slate-600">{{ $order->customer_class }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'ready' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusClass = $statusClasses[$order->status] ?? 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                                <p>Belum ada pesanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-amber-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-slate-600">
                <p>&copy; {{ date('Y') }} Kantin Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        // Auto refresh every 30 seconds
        setInterval(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
