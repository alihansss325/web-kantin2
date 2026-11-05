<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b-2 border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('menu.index') }}" class="flex items-center">
                    <i class="fas fa-utensils text-amber-600 text-2xl mr-2"></i>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Kantin Digital
                    </h1>
                </a>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if (session()->has('error'))
        <div class="fixed top-20 right-4 z-50 bg-red-50 border-l-4 border-red-500 rounded-md p-4 max-w-sm shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center text-amber-600">
                        <div class="rounded-full h-10 w-10 bg-amber-600 text-white flex items-center justify-center">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="ml-2 font-medium">Keranjang</span>
                    </div>
                    <div class="w-16 h-1 bg-amber-600 mx-2"></div>
                    <div class="flex items-center text-amber-600">
                        <div class="rounded-full h-10 w-10 bg-amber-600 text-white flex items-center justify-center">
                            <i class="fas fa-edit"></i>
                        </div>
                        <span class="ml-2 font-medium">Data Pemesan</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="rounded-full h-10 w-10 bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="ml-2 font-medium">Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200">
                    <div class="p-6 border-b-2 border-amber-100">
                        <h2 class="text-2xl font-bold text-slate-900">
                            <i class="fas fa-user-edit text-amber-600 mr-2"></i>
                            Data Pemesan
                        </h2>
                        <p class="text-slate-600 mt-1">Isi data diri untuk melanjutkan pesanan</p>
                    </div>
                    
                    <form action="{{ route('cart.process') }}" method="POST" class="p-6 space-y-6">
                        @csrf
                        
                        <!-- Nama Pemesan -->
                        <div>
                            <label for="customer_name" class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-user text-amber-600 mr-1"></i>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name') }}"
                                   required
                                   class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                   placeholder="Contoh: Ahmad Rizki">
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelas -->
                        <div>
                            <label for="customer_class" class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-school text-amber-600 mr-1"></i>
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="customer_class" 
                                   name="customer_class" 
                                   value="{{ old('customer_class') }}"
                                   required
                                   class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                   placeholder="Contoh: XII IPA 1">
                            @error('customer_class')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Meja (Opsional) -->
                        <div>
                            <label for="table_number" class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-chair text-amber-600 mr-1"></i>
                                Nomor Meja <span class="text-slate-400 text-xs">(Opsional)</span>
                            </label>
                            <input type="text" 
                                   id="table_number" 
                                   name="table_number" 
                                   value="{{ old('table_number') }}"
                                   class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                   placeholder="Contoh: A12">
                        </div>

                        <!-- Catatan (Opsional) -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-sticky-note text-amber-600 mr-1"></i>
                                Catatan Pesanan <span class="text-slate-400 text-xs">(Opsional)</span>
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="3"
                                      class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                      placeholder="Contoh: Pedas sedang, tanpa sayur">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-4">
                            <a href="{{ route('cart.index') }}" 
                               class="flex-1 py-3 px-6 text-center border-2 border-amber-500 text-amber-600 rounded-lg hover:bg-amber-50 transition-colors font-medium">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <button type="submit" 
                                    class="flex-1 py-3 px-6 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                Konfirmasi Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 sticky top-24">
                    <div class="p-6 border-b-2 border-amber-100">
                        <h2 class="text-xl font-bold text-slate-900">
                            <i class="fas fa-receipt text-amber-600 mr-2"></i>
                            Ringkasan Pesanan
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <!-- Items List -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cartItems as $item)
                            <div class="flex items-center gap-3 pb-3 border-b border-amber-100">
                                <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
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
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900 truncate">{{ $item['name'] }}</p>
                                    <p class="text-sm text-slate-600">{{ $item['quantity'] }}x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-amber-600">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="border-t-2 border-amber-200 pt-4 space-y-3">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-slate-900 pt-2 border-t border-amber-100">
                                <span>Total</span>
                                <span class="text-amber-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                            <p class="text-sm text-slate-700">
                                <i class="fas fa-info-circle text-amber-600 mr-2"></i>
                                Pesanan akan diproses setelah Anda mengkonfirmasi
                            </p>
                        </div>
                    </div>
                </div>
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
