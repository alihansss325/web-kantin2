<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Kategori - Kantin Digital</title>
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
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-amber-600 hover:text-amber-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Kategori
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border-2 border-amber-200 p-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">
                <i class="fas fa-plus-circle text-amber-600 mr-2"></i>
                Tambah Kategori Baru
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                               placeholder="Contoh: Makanan Berat">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                  placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon" class="block text-sm font-medium text-slate-700 mb-2">
                            Icon (Font Awesome)
                        </label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', 'fas fa-utensils') }}"
                               class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                               placeholder="fas fa-utensils">
                        <p class="mt-1 text-xs text-slate-500">Contoh: fas fa-utensils, fas fa-coffee, fas fa-hamburger</p>
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-2">
                            Urutan Tampil <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" required min="0"
                               class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                               placeholder="0">
                        <p class="mt-1 text-xs text-slate-500">Semakin kecil angka, semakin awal ditampilkan</p>
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-3 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300 transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
