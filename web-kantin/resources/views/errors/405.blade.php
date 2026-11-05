<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>405 - Method Not Allowed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-orange-100 mb-4">
                <i class="fas fa-ban text-orange-600 text-2xl"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">405</h1>
            <p class="text-gray-600 mb-6">Method HTTP tidak diizinkan untuk halaman ini.</p>
            
            <div class="space-y-3">
                <a href="{{ url()->previous() }}" 
                   class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                
                <a href="{{ route('menu.index') }}" 
                   class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-utensils mr-2"></i>
                    Menu Kantin
                </a>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard Admin
                </a>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Error Code: 405
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Method Not Allowed - HTTP method tidak diizinkan
                </p>
            </div>
        </div>
    </div>
</body>
</html>
