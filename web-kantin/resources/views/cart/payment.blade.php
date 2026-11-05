<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kantin Digital - Pembayaran</title>
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
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium relative">
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
                <a href="{{ route('cart.index') }}" class="block px-3 py-2 text-gray-500 hover:text-blue-600">
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
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                Pembayaran
            </h1>
            <p class="text-gray-600">Selesaikan pembayaran pesanan Anda</p>
        </div>

        @if(!empty($cartItems))
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Ringkasan Pesanan</h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Items List -->
                    <div class="space-y-3">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-medium text-gray-900">{{ $item['name'] }}</span>
                                <span class="text-gray-500 ml-2">× {{ $item['quantity'] }}</span>
                            </div>
                            <span class="font-medium">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Divider -->
                    <div class="border-t pt-4">

                        <!-- Subtotal -->
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Tax -->
                        @if($tax > 0)
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Pajak (10%)</span>
                            <span class="font-medium">
                                Rp {{ number_format($tax, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif

                        <!-- Total -->
                        <div class="flex justify-between text-lg font-bold text-gray-900 border-t pt-4">
                            <span>Total Pembayaran</span>
                            <span class="text-blue-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method Selection -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Metode Pembayaran</h2>
                </div>
                <div class="p-6">
                    <form id="paymentForm" action="{{ route('cart.process') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cash" checked class="mr-3">
                                <i class="fas fa-money-bill-wave text-green-600 mr-3"></i>
                                <div>
                                    <div class="font-medium">Tunai</div>
                                    <div class="text-sm text-gray-500">Bayar langsung di kasir</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="transfer" class="mr-3">
                                <i class="fas fa-mobile-alt text-blue-600 mr-3"></i>
                                <div>
                                    <div class="font-medium">Transfer Bank</div>
                                    <div class="text-sm text-gray-500">Transfer ke rekening sekolah</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="e_wallet" class="mr-3">
                                <i class="fas fa-wallet text-purple-600 mr-3"></i>
                                <div>
                                    <div class="font-medium">E-Wallet</div>
                                    <div class="text-sm text-gray-500">GoPay, OVO, DANA, dll</div>
                                </div>
                            </label>
                        </div>

                        <!-- Cash Amount Input (for cash payment) -->
                        <div id="cashAmount" class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Uang Tunai
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    Rp
                                </span>
                                <input type="number" 
                                       name="cash_amount" 
                                       id="cashAmountInput"
                                       class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="0"
                                       min="{{ $total }}"
                                       step="1000"
                                       required>
                            </div>
                            <div id="changeAmount" class="mt-2 text-sm text-gray-600">
                                Kembalian: Rp 0
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" 
                                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                Proses Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Status -->
            <div id="paymentStatus" class="hidden bg-white rounded-lg shadow-md">
                <div class="p-6">
                    <div class="text-center">
                        <div id="statusIcon" class="mx-auto mb-4"></div>
                        <h3 id="statusTitle" class="text-lg font-semibold mb-2"></h3>
                        <p id="statusMessage" class="text-gray-600 mb-4"></p>
                        <div id="statusActions"></div>
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

        // Payment method selection
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const cashAmount = document.getElementById('cashAmount');
                if (this.value === 'cash') {
                    cashAmount.style.display = 'block';
                    document.getElementById('cashAmountInput').required = true;
                } else {
                    cashAmount.style.display = 'none';
                    document.getElementById('cashAmountInput').required = false;
                }
            });
        });

        // Calculate change
        const cashAmountInput = document.getElementById('cashAmountInput');
        const changeAmount = document.getElementById('changeAmount');
        const totalAmount = {{ $total }};

        cashAmountInput.addEventListener('input', function() {
            const cashPaid = parseFloat(this.value) || 0;
            const change = cashPaid - totalAmount;
            
            if (change >= 0) {
                changeAmount.innerHTML = `Kembalian: <span class="font-medium text-green-600">Rp ${change.toLocaleString('id-ID')}</span>`;
            } else {
                changeAmount.innerHTML = `Kurang: <span class="font-medium text-red-600">Rp ${Math.abs(change).toLocaleString('id-ID')}</span>`;
            }
        });

        // Form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const paymentMethod = formData.get('payment_method');
            const cashAmount = formData.get('cash_amount');
            
            // Validate cash payment
            if (paymentMethod === 'cash' && parseFloat(cashAmount) < totalAmount) {
                alert('Jumlah uang tunai tidak mencukupi!');
                return;
            }

            // Show processing status
            showPaymentStatus('processing');
            
            // Simulate payment processing
            setTimeout(() => {
                // Random success/failure for demo
                const isSuccess = Math.random() > 0.2; // 80% success rate
                
                if (isSuccess) {
                    showPaymentStatus('success');
                    // Clear cart after successful payment
                    setTimeout(() => {
                        window.location.href = '{{ route("menu.index") }}';
                    }, 3000);
                } else {
                    showPaymentStatus('failed');
                }
            }, 2000);
        });

        function showPaymentStatus(status) {
            const statusDiv = document.getElementById('paymentStatus');
            const statusIcon = document.getElementById('statusIcon');
            const statusTitle = document.getElementById('statusTitle');
            const statusMessage = document.getElementById('statusMessage');
            const statusActions = document.getElementById('statusActions');
            
            statusDiv.classList.remove('hidden');
            
            switch(status) {
                case 'processing':
                    statusIcon.innerHTML = '<i class="fas fa-spinner fa-spin text-blue-600 text-4xl"></i>';
                    statusTitle.textContent = 'Memproses Pembayaran';
                    statusTitle.className = 'text-lg font-semibold mb-2 text-blue-600';
                    statusMessage.textContent = 'Mohon tunggu, pembayaran Anda sedang diproses...';
                    statusActions.innerHTML = '';
                    break;
                    
                case 'success':
                    statusIcon.innerHTML = '<i class="fas fa-check-circle text-green-600 text-4xl"></i>';
                    statusTitle.textContent = 'Pembayaran Berhasil!';
                    statusTitle.className = 'text-lg font-semibold mb-2 text-green-600';
                    statusMessage.textContent = 'Terima kasih! Pesanan Anda telah berhasil dibayar.';
                    statusActions.innerHTML = `
                        <div class="space-y-3">
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-utensils mr-2"></i>
                                Pesan Lagi
                            </a>
                            <div class="text-sm text-gray-500">
                                Anda akan dialihkan ke halaman menu dalam 3 detik...
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'failed':
                    statusIcon.innerHTML = '<i class="fas fa-times-circle text-red-600 text-4xl"></i>';
                    statusTitle.textContent = 'Pembayaran Gagal';
                    statusTitle.className = 'text-lg font-semibold mb-2 text-red-600';
                    statusMessage.textContent = 'Maaf, terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.';
                    statusActions.innerHTML = `
                        <button onclick="location.reload()" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-redo mr-2"></i>
                            Coba Lagi
                        </button>
                    `;
                    break;
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
