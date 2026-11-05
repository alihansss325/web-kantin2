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
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('menu.index') }}" class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">
                            <i class="fas fa-store mr-2"></i>Kantin Digital
                        </h1>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('menu.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        <i class="fas fa-utensils mr-1"></i>
                        Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium relative">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Keranjang
                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
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
                <a href="{{ route('menu.index') }}" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('cart.index') }}" class="block px-3 py-2 text-gray-900 hover:text-blue-600">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-shopping-cart text-blue-600 mr-3"></i>
                Keranjang Belanja
            </h1>
            <p class="text-gray-600">Kelola pesanan Anda sebelum checkout</p>
        </div>

        @if(!empty($cartItems))
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Daftar Menu</h2>
                        </div>
                        <div class="divide-y">
                            @foreach($cartItems as $item)
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 w-20 h-20">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                                            <p class="text-sm text-gray-500">{{ $item['category'] ?? '' }}</p>
                                            <p class="text-lg font-semibold text-blue-600 mt-1">
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                                    class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <span class="w-12 text-center font-medium">{{ $item['quantity'] }}</span>
                                            <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                                    class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>

                                        <!-- Remove Button -->
                                        <button onclick="removeFromCart({{ $item['id'] }})" 
                                                class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="mt-4 text-right">
                                        <span class="text-sm text-gray-500">Subtotal: </span>
                                        <span class="text-lg font-semibold text-gray-900">
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
                    <div class="bg-white rounded-lg shadow-md sticky top-24">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Ringkasan Pesanan</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Tax (if applicable) -->
                            @if($tax > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak (10%)</span>
                                <span class="font-medium">
                                    Rp {{ number_format($tax, 0, ',', '.') }}
                                </span>
                            </div>
                            @endif

                            <!-- Total -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900">Total Harga</span>
                                    <span class="text-lg font-bold text-blue-600">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <a href="{{ route('menu.index') }}" 
                                   class="w-full block text-center bg-gray-200 text-gray-800 py-3 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Lanjut Belanja
                                </a>
                                
                                <button onclick="proceedToCheckout()" 
                                        class="w-full py-3 px-4 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Proses Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-shopping-cart text-gray-400 text-6xl mb-6"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Keranjang Belanja Kosong</h2>
                    <p class="text-gray-600 mb-8">Anda belum menambahkan menu apa pun ke keranjang</p>
                    <a href="{{ route('menu.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-utensils mr-2"></i>
                        Lihat Menu
                    </a>
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-500">
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
