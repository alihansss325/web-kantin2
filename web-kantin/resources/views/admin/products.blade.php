<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Produk - Kantin Digital</title>
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
                    <a href="{{ route('admin.products.index') }}" class="text-amber-600 font-semibold">
                        <i class="fas fa-box mr-1"></i> Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="text-slate-600 hover:text-amber-600">
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
                <a href="{{ route('admin.products.index') }}" class="block py-2 text-amber-600 font-semibold">
                    <i class="fas fa-box mr-2"></i>Produk
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block py-2 text-slate-600 hover:text-amber-600">
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
                    <i class="fas fa-box text-amber-600 mr-3"></i>
                    Kelola Produk
                </h1>
                <p class="text-slate-600">Tambah, edit, dan hapus menu kantin</p>
            </div>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i>
                Tambah Produk
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
            </div>
            <button onclick="showAddModal()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Menu
            </button>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari menu..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Category Filter -->
                <div class="md:w-48">
                    <select id="categoryFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:w-48">
                    <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Menu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="productsTableBody">
                        @foreach($products as $product)
                        <tr class="product-row" data-category="{{ $product->category_id }}" data-status="{{ $product->status }}" data-name="{{ $product->name }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($product->image)
                                            <img class="h-12 w-12 rounded-full object-cover" 
                                                 src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-utensils text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $product->category->name ?? 'Tidak ada kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="editProduct({{ $product->id }})" 
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteProduct({{ $product->id }})" 
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State -->
        @if($products->count() === 0)
        <div class="text-center py-12">
            <i class="fas fa-utensils text-gray-400 text-6xl mb-6"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada menu</h3>
            <p class="text-gray-500 mb-6">Mulai dengan menambahkan menu pertama Anda</p>
            <button onclick="showAddModal()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Menu
            </button>
        </div>
        @endif
    </main>

    <!-- Add/Edit Modal -->
    <div id="productModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Tambah Menu Baru</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    <input type="hidden" name="id" id="productId">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Menu -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu</label>
                            <input type="text" 
                                   name="name" 
                                   id="nameInput"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" 
                                    id="categoryInput"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" 
                                   name="price" 
                                   id="priceInput"
                                   required
                                   min="0"
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                            <input type="number" 
                                   name="stock" 
                                   id="stockInput"
                                   required
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" 
                                    id="statusInput"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="available">Tersedia</option>
                                <option value="unavailable">Tidak Tersedia</option>
                            </select>
                        </div>

                        <!-- Unit -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                            <input type="text" 
                                   name="unit" 
                                   id="unitInput"
                                   value="porsi"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" 
                                  id="descriptionInput"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <!-- Gambar -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                        <input type="file" 
                               name="image" 
                               id="imageInput"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Max: 2MB</p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Show add modal
        function showAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Menu Baru';
            document.getElementById('methodField').value = 'POST';
            document.getElementById('productForm').action = '{{ route("admin.products.store") }}';
            document.getElementById('productForm').reset();
            document.getElementById('productModal').classList.remove('hidden');
        }

        // Edit product
        function editProduct(id) {
            // Fetch product data (simplified for demo)
            const products = @json($products);
            const product = products.find(p => p.id === id);
            
            if (product) {
                document.getElementById('modalTitle').textContent = 'Edit Menu';
                document.getElementById('methodField').value = 'PUT';
                document.getElementById('productForm').action = '{{ route("admin.products.update", ":id") }}'.replace(':id', id);
                document.getElementById('productId').value = id;
                
                // Fill form fields
                document.getElementById('nameInput').value = product.name;
                document.getElementById('categoryInput').value = product.category_id;
                document.getElementById('priceInput').value = product.price;
                document.getElementById('stockInput').value = product.stock;
                document.getElementById('statusInput').value = product.status;
                document.getElementById('unitInput').value = product.unit || 'porsi';
                document.getElementById('descriptionInput').value = product.description || '';
                
                document.getElementById('productModal').classList.remove('hidden');
            }
        }

        // Delete product
        function deleteProduct(id) {
            if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.products.destroy", ":id") }}'.replace(':id', id);
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
            document.getElementById('productForm').reset();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            filterProducts();
        });

        document.getElementById('categoryFilter').addEventListener('change', function() {
            filterProducts();
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            filterProducts();
        });

        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('.product-row');

            rows.forEach(row => {
                const name = row.dataset.name.toLowerCase();
                const category = row.dataset.category;
                const status = row.dataset.status;

                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesStatus = !statusFilter || status === statusFilter;

                if (matchesSearch && matchesCategory && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
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
