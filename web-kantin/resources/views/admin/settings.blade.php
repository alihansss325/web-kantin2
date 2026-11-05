<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kantin Digital - Pengaturan Toko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-user-shield mr-2"></i>
                        Admin Panel
                    </h1>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-tachometer-alt mr-1"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-utensils mr-1"></i>
                        Menu
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-tags mr-1"></i>
                        Kategori
                    </a>
                    <a href="{{ route('admin.settings') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-cog mr-1"></i>
                        Pengaturan
                    </a>
                </nav>

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
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
                    <i class="fas fa-tags mr-2"></i>Kategori
                </a>
                <a href="{{ route('admin.settings') }}" class="block px-3 py-2 text-gray-900 hover:text-blue-600">
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
                <i class="fas fa-cog text-blue-600 mr-3"></i>
                Pengaturan Toko
            </h1>
            <p class="text-gray-600">Kelola pengaturan dan konfigurasi toko kantin</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- General Settings -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Pengaturan Umum</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            
                            <!-- App Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                                <input type="text" 
                                       name="app_name" 
                                       value="{{ setting('app_name', 'Kantin Digital') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- App Currency -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mata Uang</label>
                                <select name="app_currency" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="IDR" {{ setting('app_currency') == 'IDR' ? 'selected' : '' }}>Rupiah (IDR)</option>
                                    <option value="USD" {{ setting('app_currency') == 'USD' ? 'selected' : '' }}>Dollar (USD)</option>
                                </select>
                            </div>

                            <!-- Tax Percentage -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pajak per Item (Rp)</label>
                                <input type="number" 
                                       name="tax_percentage" 
                                       value="{{ setting('tax_percentage', 1000) }}"
                                       min="0"
                                       step="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Pajak tetap yang dikenakan per item menu</p>
                            </div>

                            <!-- Min Topup -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minimal Topup (Rp)</label>
                                <input type="number" 
                                       name="min_topup" 
                                       value="{{ setting('min_topup', 10000) }}"
                                       min="0"
                                       step="1000"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Minimal jumlah topup saldo siswa</p>
                            </div>

                            <!-- Order Timeout -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu Pesanan (menit)</label>
                                <input type="number" 
                                       name="order_timeout" 
                                       value="{{ setting('order_timeout', 30) }}"
                                       min="5"
                                       max="120"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Waktu maksimal pesanan sebelum dibatalkan otomatis</p>
                            </div>

                            <!-- Max Order per Day -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal Pesanan per Hari</label>
                                <input type="number" 
                                       name="max_order_per_day" 
                                       value="{{ setting('max_order_per_day', 10) }}"
                                       min="1"
                                       max="50"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Maksimal pesanan yang bisa dibuat siswa per hari</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Store Hours -->
                <div class="bg-white rounded-lg shadow-md mt-6">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Jam Operasional</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <form action="{{ route('admin.settings.hours') }}" method="POST">
                            @csrf
                            
                            <!-- Monday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Senin</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="monday_open" 
                                           value="{{ setting('monday_open', '07:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="monday_close" 
                                           value="{{ setting('monday_close', '15:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Tuesday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Selasa</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="tuesday_open" 
                                           value="{{ setting('tuesday_open', '07:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="tuesday_close" 
                                           value="{{ setting('tuesday_close', '15:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Wednesday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Rabu</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="wednesday_open" 
                                           value="{{ setting('wednesday_open', '07:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="wednesday_close" 
                                           value="{{ setting('wednesday_close', '15:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Thursday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Kamis</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="thursday_open" 
                                           value="{{ setting('thursday_open', '07:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="thursday_close" 
                                           value="{{ setting('thursday_close', '15:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Friday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Jumat</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="friday_open" 
                                           value="{{ setting('friday_open', '07:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="friday_close" 
                                           value="{{ setting('friday_close', '15:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Saturday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Sabtu</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="saturday_open" 
                                           value="{{ setting('saturday_open', '07:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="saturday_close" 
                                           value="{{ setting('saturday_close', '13:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Sunday -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Minggu</label>
                                <div class="flex items-center space-x-2">
                                    <input type="time" 
                                           name="sunday_open" 
                                           value="{{ setting('sunday_open', '08:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                    <span class="text-gray-500">-</span>
                                    <input type="time" 
                                           name="sunday_close" 
                                           value="{{ setting('sunday_close', '12:00') }}"
                                           class="px-3 py-1 border border-gray-300 rounded">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Jam Operasional
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Status Panel -->
            <div class="lg:col-span-1">
                <!-- Store Status -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Status Toko</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Store Status -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Status Toko</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Buka
                                </span>
                            </div>

                            <!-- Current Time -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Jam Sekarang</span>
                                <span class="text-sm text-gray-600" id="currentTime">
                                    {{ now()->format('H:i') }}
                                </span>
                            </div>

                            <!-- Today's Orders -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Pesanan Hari Ini</span>
                                <span class="text-sm font-semibold text-blue-600">
                                    {{ App\Models\Transaction::today()->count() }}
                                </span>
                            </div>

                            <!-- Active Products -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Menu Aktif</span>
                                <span class="text-sm font-semibold text-green-600">
                                    {{ App\Models\Product::available()->count() }}
                                </span>
                            </div>

                            <!-- Low Stock Alert -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Stok Menipis</span>
                                <span class="text-sm font-semibold text-red-600">
                                    {{ App\Models\Product::lowStock()->count() }}
                                </span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-6 space-y-3">
                            <button onclick="toggleStoreStatus()" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-power-off mr-2"></i>
                                Tutup Toko
                            </button>
                            
                            <a href="{{ route('admin.products.index') }}" 
                               class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-utensils mr-2"></i>
                                Kelola Menu
                            </a>
                            
                            <a href="{{ route('admin.dashboard') }}" 
                               class="w-full block text-center bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fas fa-chart-line mr-2"></i>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Notifikasi</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Low Stock Alert -->
                            @if(App\Models\Product::lowStock()->count() > 0)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">
                                            {{ App\Models\Product::lowStock()->count() }} Menu Stok Menipis
                                        </h3>
                                        <div class="mt-1 text-sm text-yellow-700">
                                            Segera tambah stok menu yang menipis
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Pending Orders -->
                            @if(App\Models\Transaction::pending()->count() > 0)
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-blue-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            {{ App\Models\Transaction::pending()->count() }} Pesanan Menunggu
                                        </h3>
                                        <div class="mt-1 text-sm text-blue-700">
                                            Ada pesanan yang perlu diproses
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- System Status -->
                            <div class="bg-green-50 border border-green-200 rounded-md p-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">
                                            Sistem Normal
                                        </h3>
                                        <div class="mt-1 text-sm text-green-700">
                                            Semua sistem berfungsi dengan baik
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                              now.getMinutes().toString().padStart(2, '0');
            document.getElementById('currentTime').textContent = timeString;
        }

        // Update time every minute
        setInterval(updateCurrentTime, 60000);

        // Toggle store status
        function toggleStoreStatus() {
            const button = event.target;
            const isOpen = button.textContent.includes('Tutup');
            
            if (confirm(isOpen ? 'Apakah Anda yakin ingin menutup toko?' : 'Apakah Anda yakin ingin membuka toko?')) {
                // In real app, this would make an API call
                button.textContent = isOpen ? 'Buka Toko' : 'Tutup Toko';
                button.className = isOpen ? 
                    'w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors' :
                    'w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors';
            }
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
