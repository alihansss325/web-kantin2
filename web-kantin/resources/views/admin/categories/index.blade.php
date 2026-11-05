<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Kategori - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b-2 border-amber-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-utensils text-amber-600 text-2xl mr-2"></i>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Kantin Digital
                    </h1>
                </div>
                <nav class="hidden md:flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-receipt mr-1"></i> Pesanan
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="text-slate-600 hover:text-amber-600">
                        <i class="fas fa-box mr-1"></i> Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="text-amber-600 font-semibold">
                        <i class="fas fa-tags mr-1"></i> Kategori
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-600 hover:text-red-600">
                            <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                        </button>
                    </form>
                </nav>

                <button class="md:hidden text-slate-600" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-receipt mr-2"></i>Pesanan
                </a>
                <a href="{{ route('admin.products.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
                    <i class="fas fa-box mr-2"></i>Produk
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block py-2 text-amber-600 font-semibold">
                    <i class="fas fa-tags mr-2"></i>Kategori
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-slate-600 hover:text-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">
                    <i class="fas fa-tags text-amber-600 mr-3"></i>
                    Kelola Kategori
                </h1>
                <p class="text-slate-600">Atur kategori menu kantin</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i>
                Tambah Kategori
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-200 rounded-xl p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
            <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-6 hover:shadow-2xl transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($category->icon)
                            <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center">
                                <i class="{{ $category->icon }} text-white text-xl"></i>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">{{ $category->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $category->products_count ?? 0 }} menu</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.categories.toggle', $category) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-sm px-3 py-1 rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                </div>

                @if($category->description)
                    <p class="text-sm text-slate-600 mb-4">{{ $category->description }}</p>
                @endif

                <div class="flex gap-2 pt-4 border-t border-amber-100">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="flex-1 text-center px-4 py-2 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="flex-1" 
                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-inbox text-6xl text-slate-300 mb-4"></i>
                <p class="text-slate-500 text-lg">Belum ada kategori</p>
                <a href="{{ route('admin.categories.create') }}" class="inline-block mt-4 text-amber-600 hover:text-amber-700 font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah kategori pertama
                </a>
            </div>
            @endforelse
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
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>
</body>
</html>
