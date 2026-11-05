<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b-2 border-amber-200">
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

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Animation -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-green-400 to-green-600 rounded-full mb-6 animate-bounce">
                <i class="fas fa-check text-white text-5xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-slate-900 mb-3">Pesanan Berhasil!</h1>
            <p class="text-xl text-slate-600">Terima kasih atas pesanan Anda</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 overflow-hidden mb-6">
            <!-- Order Number -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
                <div class="text-center">
                    <p class="text-sm opacity-90 mb-2">Nomor Pesanan</p>
                    <p class="text-3xl font-bold tracking-wider">{{ $order->order_number }}</p>
                    <p class="text-sm opacity-90 mt-2">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="p-6 border-b-2 border-amber-100">
                <h3 class="text-lg font-bold text-slate-900 mb-4">
                    <i class="fas fa-user text-amber-600 mr-2"></i>
                    Informasi Pemesan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-600">Nama</p>
                        <p class="font-semibold text-slate-900">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Kelas</p>
                        <p class="font-semibold text-slate-900">{{ $order->customer_class }}</p>
                    </div>
                    @if($order->table_number)
                    <div>
                        <p class="text-sm text-slate-600">Nomor Meja</p>
                        <p class="font-semibold text-slate-900">{{ $order->table_number }}</p>
                    </div>
                    @endif
                    @if($order->notes)
                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-600">Catatan</p>
                        <p class="font-semibold text-slate-900">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-6 border-b-2 border-amber-100">
                <h3 class="text-lg font-bold text-slate-900 mb-4">
                    <i class="fas fa-shopping-bag text-amber-600 mr-2"></i>
                    Detail Pesanan
                </h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-3 bg-amber-50 rounded-lg">
                        <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-amber-200 flex items-center justify-center">
                                    <i class="fas fa-utensils text-amber-600"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-slate-900">{{ $item->product_name }}</p>
                            <p class="text-sm text-slate-600">{{ $item->quantity }}x Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-bold text-amber-600">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="p-6 bg-amber-50">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-slate-900">Total Pembayaran</span>
                    <span class="text-3xl font-bold text-amber-600">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Status Info -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-slate-900 mb-2">Status Pesanan: <span class="text-blue-600">{{ $order->status_label }}</span></h3>
                    <p class="text-slate-700 mb-3">Pesanan Anda sedang diproses oleh penjual kantin. Silakan menunggu di area kantin.</p>
                    <div class="space-y-2 text-sm text-slate-600">
                        <p><i class="fas fa-clock text-amber-600 mr-2"></i> Estimasi waktu: 10-15 menit</p>
                        <p><i class="fas fa-bell text-amber-600 mr-2"></i> Anda akan dipanggil saat pesanan siap</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('menu.index') }}" 
               class="flex-1 py-4 px-6 text-center bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl font-medium">
                <i class="fas fa-utensils mr-2"></i>
                Pesan Lagi
            </a>
            <button onclick="window.print()" 
                    class="flex-1 py-4 px-6 text-center border-2 border-amber-500 text-amber-600 rounded-lg hover:bg-amber-50 transition-colors font-medium">
                <i class="fas fa-print mr-2"></i>
                Cetak Struk
            </button>
        </div>

        <!-- Tips -->
        <div class="mt-8 p-6 bg-white rounded-xl border-2 border-amber-200">
            <h3 class="font-bold text-slate-900 mb-3">
                <i class="fas fa-lightbulb text-amber-600 mr-2"></i>
                Tips
            </h3>
            <ul class="space-y-2 text-slate-700">
                <li><i class="fas fa-check text-green-500 mr-2"></i> Simpan nomor pesanan Anda</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Tunggu panggilan dari penjual kantin</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Tunjukkan nomor pesanan saat mengambil</li>
            </ul>
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

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-white.rounded-xl.shadow-lg, .bg-white.rounded-xl.shadow-lg * {
                visibility: visible;
            }
            .bg-white.rounded-xl.shadow-lg {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</body>
</html>
