<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kantin Digital - Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #f59e0b, #f97316, #ea580c);
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b-2 border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <i class="fas fa-utensils text-amber-600 text-2xl mr-2"></i>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Kantin Digital
                    </h1>
                </a>
                
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('welcome') }}" class="text-amber-600 font-semibold">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                    <a href="{{ route('menu.index') }}" class="text-slate-600 hover:text-amber-600 transition-colors">
                        <i class="fas fa-utensils mr-1"></i> Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="relative text-slate-600 hover:text-amber-600 transition-colors">
                        <i class="fas fa-shopping-cart mr-1"></i> Keranjang
                        <span class="cart-badge absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" style="display: none;">0</span>
                    </a>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-amber-600 transition-colors">
                            <i class="fas fa-user-shield mr-1"></i> Admin
                        </a>
                    @endif
                </nav>

                <button class="md:hidden text-slate-600" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="{{ route('welcome') }}" class="block py-2 text-amber-600 font-semibold">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="{{ route('menu.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('cart.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                </a>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                        <i class="fas fa-user-shield mr-2"></i>Admin
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Selamat Datang di Kantin Digital</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Pesan makanan favoritmu dengan mudah dan cepat</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('menu.index') }}" class="px-8 py-4 bg-white text-amber-600 rounded-lg hover:bg-amber-50 transition-all shadow-lg hover:shadow-xl font-semibold text-lg">
                    <i class="fas fa-utensils mr-2"></i> Lihat Menu
                </a>
                <a href="{{ route('cart.index') }}" class="px-8 py-4 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all shadow-lg hover:shadow-xl font-semibold text-lg border-2 border-white">
                    <i class="fas fa-shopping-cart mr-2"></i> Keranjang
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-slate-900 mb-3">Mengapa Kantin Digital?</h2>
                <p class="text-xl text-slate-600">Sistem pemesanan makanan modern untuk sekolah</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-8 text-center hover:shadow-2xl transition-all hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-white text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Cepat & Mudah</h3>
                    <p class="text-slate-600">Pesan makanan favoritmu hanya dengan beberapa klik</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-8 text-center hover:shadow-2xl transition-all hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check-circle text-white text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Tanpa Antri</h3>
                    <p class="text-slate-600">Pesan sebelum istirahat, langsung ambil saat siap</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-8 text-center hover:shadow-2xl transition-all hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-white text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Hemat Waktu</h3>
                    <p class="text-slate-600">Lebih banyak waktu untuk belajar dan istirahat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-slate-900 mb-3">Menu Populer Hari Ini</h2>
                <p class="text-xl text-slate-600">Pilih makanan dan minuman favoritmu</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="relative h-48 bg-amber-50">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-utensils text-amber-300 text-6xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 left-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-check-circle mr-1"></i> Tersedia
                        </div>
                        <div class="absolute top-2 right-2 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-star mr-1"></i> Populer
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $product->description }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-amber-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('menu.index') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl font-semibold text-lg">
                    <i class="fas fa-th-list mr-2"></i> Lihat Semua Menu
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-amber-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-slate-600">
                <p class="text-lg">&copy; {{ date('Y') }} Kantin Digital. All rights reserved.</p>
                <p class="text-sm mt-2">Dibuat dengan <i class="fas fa-heart text-red-500"></i> untuk sekolah Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-2xl"></i>
            <div>
                <p class="font-semibold">Berhasil!</p>
                <p id="toastMessage" class="text-sm">Produk ditambahkan ke keranjang</p>
            </div>
        </div>
    </div>
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        // Add to cart
        function addToCart(id, name, price) {
            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    updateCartCount(data.cart_count);
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            
            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }

        // Update cart count
        function updateCartCount(count) {
            const badges = document.querySelectorAll('.cart-badge');
            badges.forEach(badge => {
                if (count && count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
        }

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/cart/count')
                .then(response => response.json())
                .then(data => {
                    updateCartCount(data.count);
                })
                .catch(error => {
                    console.error('Error fetching cart count:', error);
                });
        });
    </script>
</body>
</html>
