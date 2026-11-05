<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 rounded-md p-4 max-w-sm">
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
        <div class="fixed top-4 right-4 z-50 bg-red-50 border border-red-200 rounded-md p-4 max-w-sm">
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

    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100 mb-4">
                <i class="fas fa-store text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Kantin Digital</h1>
            <p class="text-gray-600 mb-8">Sistem kantin modern untuk sekolah Anda</p>
            
            <div class="space-y-4">
                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-store mr-2"></i>
                    Lihat Menu
                </a>
                
                <div class="text-sm text-gray-600">
                    <a href="{{ route('cart.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Lihat Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const notifications = document.querySelectorAll('.fixed.top-4');
            notifications.forEach(notification => {
                notification.remove();
            });
        }, 5000);
    </script>
</body>
</html>
