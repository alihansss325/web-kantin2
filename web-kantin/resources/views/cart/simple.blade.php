<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kantin Digital - Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b-2 border-amber-200 sticky top-0 z-40">
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
                    <a href="{{ route('menu.index') }}" class="text-slate-600 hover:text-amber-600 transition-colors">
                        <i class="fas fa-utensils mr-1"></i> Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-amber-600 font-semibold relative">
                        <i class="fas fa-shopping-cart mr-1"></i> Keranjang
                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
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
                <a href="{{ route('menu.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('cart.index') }}" class="block py-2 text-amber-600 font-semibold">
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

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-50 border-l-4 border-green-500 rounded-md p-4 max-w-sm shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-20 right-4 z-50 bg-red-50 border-l-4 border-red-500 rounded-md p-4 max-w-sm shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-red-800">Error!</h3>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">
                <i class="fas fa-shopping-cart text-amber-600 mr-3"></i>
                Keranjang Belanja
            </h1>
            <p class="text-slate-600 text-lg">Kelola pesanan Anda sebelum checkout</p>
        </div>

        @if(!empty($cartItems))
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200">
                        <div class="p-6 border-b-2 border-amber-100">
                            <h2 class="text-xl font-bold text-slate-900">Daftar Menu</h2>
                        </div>
                        <div class="divide-y">
                            @foreach($cartItems as $item)
                                <div class="p-4 md:p-6">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-amber-100 flex items-center justify-center">
                                                    <i class="fas fa-utensils text-amber-600"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $item['name'] }}</h3>
                                            <p class="text-sm text-slate-600">{{ $item['category'] ?? '' }}</p>
                                            <p class="text-lg font-bold text-amber-600 mt-1">
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Quantity Controls & Remove -->
                                        <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                                            <div class="flex items-center gap-2">
                                                <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                                        class="w-8 h-8 rounded-full bg-amber-100 hover:bg-amber-200 text-amber-600 flex items-center justify-center transition-colors">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <span class="w-12 text-center font-semibold text-slate-900">{{ $item['quantity'] }}</span>
                                                <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                                        class="w-8 h-8 rounded-full bg-amber-100 hover:bg-amber-200 text-amber-600 flex items-center justify-center transition-colors">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </div>

                                            <button onclick="removeFromCart({{ $item['id'] }})" 
                                                    class="text-red-500 hover:text-red-700 transition-colors p-2">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="mt-4 flex justify-between items-center pt-3 border-t-2 border-amber-200">
                                        <span class="text-sm text-slate-600">Subtotal:</span>
                                        <span class="text-lg font-semibold text-slate-900">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200">
                        <div class="p-6 border-b-2 border-amber-100">
                            <h2 class="text-xl font-bold text-slate-900">
                                <i class="fas fa-receipt text-amber-600 mr-2"></i>
                                Ringkasan Pesanan
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between">
                                <span class="text-slate-600">Subtotal</span>
                                <span class="font-medium text-slate-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Total -->
                            <div class="border-t-2 border-amber-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-slate-900">Total Harga</span>
                                    <span class="text-2xl font-bold text-amber-600">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3 mt-6">
                                <a href="{{ route('menu.index') }}" 
                                   class="w-full block text-center border-2 border-amber-500 text-amber-600 py-3 px-4 rounded-lg hover:bg-amber-50 transition-colors font-medium">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Lanjut Belanja
                                </a>
                                
                                <a href="{{ route('cart.checkout') }}" 
                                   class="w-full block text-center py-3 px-4 rounded-lg bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl font-medium">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Proses Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-32 h-32 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-cart text-amber-600 text-6xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Keranjang Belanja Kosong</h2>
                    <p class="text-slate-600 mb-8 text-lg">Anda belum menambahkan menu apa pun ke keranjang</p>
                    <a href="{{ route('menu.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl font-semibold text-lg">
                        <i class="fas fa-utensils mr-2"></i>
                        Lihat Menu
                    </a>
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-amber-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-slate-600">
                <p>&copy; {{ date('Y') }} Kantin Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Update quantity
        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) {
                removeFromCart(productId);
                return;
            }

            fetch(`/cart/update/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Gagal memperbarui kuantitas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        // Remove from cart
        function removeFromCart(productId) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                fetch(`/cart/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        }

        // Proceed to checkout
        function proceedToCheckout() {
            window.location.href = '{{ route("cart.checkout") }}';
        }
    </script>
</body>
</html>
