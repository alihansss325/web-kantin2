<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <a href="{{ route('welcome') }}" class="text-slate-600 hover:text-amber-600 transition-colors">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                    <a href="{{ route('menu.index') }}" class="text-amber-600 font-semibold">
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
                <a href="{{ route('welcome') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="{{ route('menu.index') }}" class="block py-2 text-amber-600 font-semibold">
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
    <section class="bg-gradient-to-r from-amber-500 to-orange-500 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Menu Kantin</h1>
            <p class="text-xl opacity-90">Pilih makanan dan minuman favoritmu</p>
        </div>
    </section>

    <!-- Filter & Search -->
    <section class="py-6 bg-white border-b-2 border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Category Filter -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterCategory('all')" 
                            class="category-btn px-4 py-2 rounded-lg border-2 border-amber-500 bg-amber-500 text-white font-medium transition-all hover:shadow-lg">
                        <i class="fas fa-th mr-1"></i> Semua
                    </button>
                    @foreach($categories as $category)
                    <button onclick="filterCategory('{{ $category->id }}')" 
                            class="category-btn px-4 py-2 rounded-lg border-2 border-amber-500 text-amber-600 bg-white font-medium transition-all hover:bg-amber-50">
                        <i class="fas fa-{{ $category->icon }} mr-1"></i> {{ $category->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Search -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <input type="text" 
                               id="searchInput" 
                               placeholder="Cari menu..." 
                               class="w-full md:w-64 pl-10 pr-4 py-2 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <i class="fas fa-search absolute left-3 top-3 text-amber-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                <div class="product-card bg-white rounded-xl shadow-lg border-2 border-amber-200 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2" 
                     data-category="{{ $product->category_id }}"
                     data-name="{{ strtolower($product->name) }}">
                    <!-- Product Image -->
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
                        
                        @if($product->is_featured)
                        <div class="absolute top-2 right-2 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-star mr-1"></i> Populer
                        </div>
                        @endif

                        <div class="absolute top-2 left-2">
                            @if($product->stock > 0)
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia
                                </span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-times-circle mr-1"></i> Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-5">
                        <div class="mb-3">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $product->name }}</h3>
                            <p class="text-sm text-slate-600 line-clamp-2">{{ $product->description }}</p>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-2xl font-bold text-amber-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-slate-500">Stok: {{ $product->stock }}</p>
                            </div>
                        </div>

                        @if($product->stock > 0)
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang
                        </button>
                        @else
                        <button disabled 
                                class="w-full py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium">
                            <i class="fas fa-times-circle mr-2"></i> Stok Habis
                        </button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-inbox text-6xl text-slate-300 mb-4"></i>
                    <p class="text-xl text-slate-500">Tidak ada menu tersedia</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-amber-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-slate-600">
                <p>&copy; {{ date('Y') }} Kantin Digital. All rights reserved.</p>
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

        // Filter by category
        function filterCategory(categoryId) {
            const cards = document.querySelectorAll('.product-card');
            const buttons = document.querySelectorAll('.category-btn');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('bg-amber-500', 'text-white');
                btn.classList.add('bg-white', 'text-amber-600');
            });
            event.target.classList.remove('bg-white', 'text-amber-600');
            event.target.classList.add('bg-amber-500', 'text-white');
            
            // Filter cards
            cards.forEach(card => {
                if (categoryId === 'all' || card.dataset.category === categoryId) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            
            cards.forEach(card => {
                const name = card.dataset.name;
                if (name.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

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
