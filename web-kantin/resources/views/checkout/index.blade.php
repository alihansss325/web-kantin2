<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        school: {
                            orange: '#fb923c',
                            green: '#10b981',
                            blue: '#3b82f6'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-school-blue to-school-green rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-white text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-xl font-bold text-gray-900">Kantin Digital</h1>
                        </div>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-school-blue px-3 py-2 text-sm font-medium transition-colors">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="{{ route('menu.index') }}" class="text-gray-700 hover:text-school-blue px-3 py-2 text-sm font-medium transition-colors">
                        <i class="fas fa-utensils mr-2"></i>Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-school-blue px-3 py-2 text-sm font-medium transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                    </a>
                    <a href="{{ route('checkout.index') }}" class="bg-school-blue text-white px-4 py-2 rounded-lg text-sm font-medium">
                        <i class="fas fa-credit-card mr-2"></i>Pembayaran
                    </a>
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
                <a href="{{ route('welcome') }}" class="block px-3 py-2 text-gray-700 hover:text-school-blue hover:bg-gray-50 rounded-md">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="{{ route('menu.index') }}" class="block px-3 py-2 text-gray-700 hover:text-school-blue hover:bg-gray-50 rounded-md">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('cart.index') }}" class="block px-3 py-2 text-gray-700 hover:text-school-blue hover:bg-gray-50 rounded-md">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                </a>
                <a href="{{ route('checkout.index') }}" class="block px-3 py-2 bg-school-blue text-white rounded-md">
                    <i class="fas fa-credit-card mr-2"></i>Pembayaran
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-credit-card text-school-blue mr-3"></i>
                Pembayaran
            </h1>
            <p class="text-gray-600">Selesaikan pembayaran pesanan Anda</p>
        </div>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-900">Detail Pesanan</h2>
                        </div>
                        <div class="p-6">
                            <!-- Customer Info -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemesan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" name="customer_name" id="customerName" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-school-blue focus:border-transparent"
                                               placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                                        <select name="customer_class" id="customerClass" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-school-blue focus:border-transparent">
                                            <option value="">Pilih kelas</option>
                                            <option value="X-1">X-1</option>
                                            <option value="X-2">X-2</option>
                                            <option value="X-3">X-3</option>
                                            <option value="XI-1">XI-1</option>
                                            <option value="XI-2">XI-2</option>
                                            <option value="XI-3">XI-3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Pesanan</h3>
                                <div class="space-y-3">
                                    @foreach(session('cart') as $item)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden">
                                                    <img src="https://via.placeholder.com/48x48/3b82f6/ffffff?text={{ $item['name'] }}" 
                                                         alt="{{ $item['name'] }}" 
                                                         class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $item['name'] }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-semibold text-school-blue">
                                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-school-blue focus:border-transparent"
                                          placeholder="Tambahkan catatan pesanan..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-24">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-900">Ringkasan Pembayaran</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">
                                    Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }), 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <!-- Tax -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pajak (10%)</span>
                                <span class="font-semibold">
                                    Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }) * 0.1, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <!-- Total -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total Pembayaran</span>
                                    <span class="text-2xl font-bold text-school-blue">
                                        Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }) * 1.1, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="payment_method" value="cash" class="mr-3" checked>
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-money-bill-wave text-school-green mr-2"></i>
                                                <span class="font-medium">Tunai di Loket</span>
                                            </div>
                                            <p class="text-sm text-gray-600">Bayar langsung di kantin</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="payment_method" value="balance" class="mr-3">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-wallet text-school-blue mr-2"></i>
                                                <span class="font-medium">Saldo Siswa</span>
                                            </div>
                                            <p class="text-sm text-gray-600">Gunakan saldo kantin digital</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 space-y-3">
                                <button onclick="processPayment()" 
                                        class="w-full bg-school-green text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Bayar Sekarang
                                </button>
                                
                                <a href="{{ route('cart.index') }}" 
                                   class="w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-center block">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-gray-400 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Keranjang Kosong</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Belum ada produk di keranjang Anda. Yuk, lihat menu makanan yang tersedia!
                </p>
                <a href="{{ route('menu.index') }}" 
                   class="inline-flex items-center bg-school-blue text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                    <i class="fas fa-utensils mr-2"></i>
                    Lihat Menu
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2024 Kantin Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-school-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
                <p class="text-gray-600">Pesanan Anda telah diproses. Silakan ambil pesanan di kantin.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">No. Pesanan:</span>
                    <span class="font-semibold">#ORD-{{ date('YmdHis') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-school-blue">
                        Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }) * 1.1, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <button onclick="closePaymentModal()" 
                    class="w-full bg-school-blue text-white py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                <i class="fas fa-times mr-2"></i>
                Tutup
            </button>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Process payment
        function processPayment() {
            const customerName = document.getElementById('customerName').value;
            const customerClass = document.getElementById('customerClass').value;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            if (!customerName) {
                alert('Silakan masukkan nama lengkap Anda');
                return;
            }

            // Show payment modal
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paymentModal').classList.add('flex');

            // Clear cart after successful payment
            setTimeout(() => {
                localStorage.removeItem('cart');
                // Redirect to home after 3 seconds
                setTimeout(() => {
                    window.location.href = '{{ route('welcome') }}';
                }, 3000);
            }, 1000);
        }

        // Close payment modal
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('paymentModal').classList.remove('flex');
            
            // Clear cart and redirect to home
            localStorage.removeItem('cart');
            window.location.href = '{{ route('welcome') }}';
        }
    </script>
</body>
</html>
