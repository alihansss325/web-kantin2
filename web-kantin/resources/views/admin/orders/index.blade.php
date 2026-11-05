<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pesanan - Kantin Digital</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="text-amber-600 font-semibold">
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
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block py-2 text-amber-600 font-semibold">
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

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-50 border-l-4 border-green-500 rounded-md p-4 max-w-sm shadow-lg">
            <div class="flex">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">
                <i class="fas fa-receipt text-amber-600 mr-3"></i>
                Kelola Pesanan
            </h1>
            <p class="text-slate-600">Pantau dan kelola pesanan pelanggan</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Total Pesanan</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['today_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-amber-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-yellow-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Menunggu</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-blue-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Diproses</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['processing'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-spinner text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-green-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Siap Diambil</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['ready'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Pendapatan</p>
                        <p class="text-lg font-bold text-amber-600">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-amber-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nomor pesanan / Nama" 
                           class="w-full px-4 py-2 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full py-2 px-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-amber-500 to-orange-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">No. Pesanan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Kelas</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Items</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100">
                        @forelse($orders as $order)
                        <tr class="hover:bg-amber-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-semibold text-amber-600">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">{{ $order->customer_name }}</p>
                                @if($order->table_number)
                                <p class="text-sm text-slate-600">Meja: {{ $order->table_number }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-700">{{ $order->customer_class }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $order->total_items }} item</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <select onchange="updateStatus({{ $order->id }}, this.value)" 
                                        class="px-3 py-1 rounded-full text-sm font-medium border-2 
                                        @if($order->status == 'pending') bg-yellow-100 border-yellow-300 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 border-blue-300 text-blue-800
                                        @elseif($order->status == 'ready') bg-green-100 border-green-300 text-green-800
                                        @elseif($order->status == 'completed') bg-gray-100 border-gray-300 text-gray-800
                                        @else bg-red-100 border-red-300 text-red-800
                                        @endif">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $order->created_at->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.print', $order) }}" 
                                       target="_blank"
                                       class="px-3 py-1 bg-amber-500 text-white rounded-lg hover:bg-amber-600 text-sm">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                                <p>Tidak ada pesanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
            <div class="px-6 py-4 border-t-2 border-amber-100">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </main>

    <script>
        function updateStatus(orderId, status) {
            if (!confirm('Ubah status pesanan?')) {
                location.reload();
                return;
            }

            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
                location.reload();
            });
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        // Auto hide notifications
        setTimeout(() => {
            document.querySelectorAll('.fixed.top-20').forEach(el => el.remove());
        }, 5000);

        // Auto refresh every 30 seconds
        setInterval(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
