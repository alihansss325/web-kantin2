<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu - Kantin Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --school-blue: #3b82f6;
            --school-green: #10b981;
            --school-orange: #fb923c;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--school-blue), var(--school-green));
            color: white;
        }
        
        .card-hover {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .btn-school {
            background: var(--school-blue);
            border: none;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-school:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--school-blue) !important;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--school-orange);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .filter-btn {
            border: 2px solid var(--school-blue);
            color: var(--school-blue);
            background: white;
            transition: all 0.3s;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--school-blue);
            color: white;
        }
        
        .price-tag {
            background: var(--school-green);
            color: white;
            padding: 4px 8px;
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
                <i class="fas fa-utensils me-2"></i>
                Kantin Digital
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('menu.index') }}">
                            <i class="fas fa-utensils me-1"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i> Keranjang
                            <span class="cart-badge" style="display: none;">0</span>
                        </a>
                    </li>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-user-shield me-1"></i> Admin
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header py-5">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-3">Menu Kantin</h1>
            <p class="lead">Pilih makanan dan minuman favoritmu</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn filter-btn active" onclick="filterProducts('all')">
                            <i class="fas fa-th me-1"></i> Semua
                        </button>
                        <button class="btn filter-btn" onclick="filterProducts('makanan')">
                            <i class="fas fa-hamburger me-1"></i> Makanan
                        </button>
                        <button class="btn filter-btn" onclick="filterProducts('minuman')">
                            <i class="fas fa-coffee me-1"></i> Minuman
                        </button>
                        <button class="btn filter-btn" onclick="filterProducts('snack')">
                            <i class="fas fa-cookie me-1"></i> Snack
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari menu..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4" id="menuGrid">
                <!-- Makanan Cards -->
                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="makanan">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/nasi-goreng.jpg') }}" 
                             class="card-img-top" alt="Nasi Goreng">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Nasi Goreng</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Nasi goreng dengan telur dan ayam suwir</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 13.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(1, 'Nasi Goreng', 13000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="makanan">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/nasi-mentai.jpg') }}" 
                             class="card-img-top" alt="Nasi Mentai">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Nasi Mentai</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Nasi dengan saus mentai dan salmon</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 13.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(2, 'Nasi Mentai', 13000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="makanan">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/nasi-cokot.jpg') }}" 
                             class="card-img-top" alt="Nasi Cokot">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Nasi Cokot</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Nasi dengan lauk ayam suwir pedas khas</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 6.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(3, 'Nasi Cokot', 6000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/bakpau.jpg') }}" 
                             class="card-img-top" alt="Bakpao">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Bakpao</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Bakpao lembut dengan isian daging ayam</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 6.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(4, 'Bakpao', 6000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Minuman Cards -->
                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="minuman">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/kopi-sip.jpg') }}" 
                             class="card-img-top" alt="Kopi SIP">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Kopi SIP</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Minuman kopi populer dari espresso biji kopi premium, dipadukan susu creamy dan gula aren, dengan rasa manis dan gurih yang seimbang</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 8.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(5, 'Kopi SIP', 8000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/jasuke.jpg') }}" 
                             class="card-img-top" alt="Jasuke">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Jasuke</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Jasuke adalah jagung manis hangat yang dipadukan susu dan keju, dengan rasa manis, gurih, dan lezat</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 7.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(6, 'Jasuke', 7000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="minuman">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/red-velvet.jpg') }}" 
                             class="card-img-top" alt="Red Velvet">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Red Velvet</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Minuman red velvet dengan rasa manis lembut dan creamy, berwarna merah menarik, cocok dinikmati kapan saja</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 12.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(7, 'Red Velvet', 12000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Snack Cards -->
                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/brownies.jpg') }}" 
                             class="card-img-top" alt="Brownies">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Brownies</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Brownies coklat lembut dengan topping keju</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 12.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(8, 'Brownies', 12000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/tahu-walik.jpg') }}" 
                             class="card-img-top" alt="Tahu Walik">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Tahu Walik</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Tahu goreng krispi dengan bumbu khas</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 10.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(9, 'Tahu Walik', 10000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/batagor.jpg') }}" 
                             class="card-img-top" alt="Batagor">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Batagor</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Batagor goreng dengan bumbu kacang</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 10.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(8, 'Batagor', 10000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/siomay.jpg') }}" 
                             class="card-img-top" alt="Siomay">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Siomay</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Siomay ikan dengan bumbu kacang</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 10.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(9, 'Siomay', 10000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3 menu-item" data-category="snack">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/tempura.jpg') }}" 
                             class="card-img-top" alt="Tempura">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">Tempura</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            <p class="card-text text-muted">Tempura goreng renyah dengan saus khas</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Rp 10.000</span>
                                <button class="btn btn-school btn-sm" onclick="addToCart(10, 'Tempura', 10000)">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Kantin Digital. All rights reserved.</p>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="cartToast" class="toast" role="alert">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Produk ditambahkan ke keranjang
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(id, name, price) {
            console.log('Adding to cart:', { id, name, price }); // Debug log
            
            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Cart response:', data); // Debug log
                    
                    // Show toast
                    const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                    document.querySelector('#cartToast .toast-body').textContent = data.message;
                    toast.show();
                    
                    // Update cart badge
                    updateCartCount(data.cart_count);
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        function updateCartCount(count = null) {
            const badges = document.querySelectorAll('.cart-badge');
            badges.forEach(badge => {
                if (count && count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
        }

        function filterProducts(category) {
            const items = document.querySelectorAll('.menu-item');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.toLowerCase().includes(category) || 
                    (category === 'all' && btn.textContent.includes('Semua'))) {
                    btn.classList.add('active');
                }
            });
            
            // Filter items
            items.forEach(item => {
                if (category === 'all') {
                    item.style.display = 'block';
                } else {
                    item.style.display = item.dataset.category === category ? 'block' : 'none';
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.menu-item');
            
            items.forEach(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                const description = item.querySelector('.card-text').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch current cart count from server
            fetch('/api/cart/count')
                .then(response => response.json())
                .then(data => {
                    updateCartCount(data.count);
                })
                .catch(error => {
                    console.error('Error fetching cart count:', error);
                    updateCartCount(0);
                });
        });
    </script>
</body>
</html>
