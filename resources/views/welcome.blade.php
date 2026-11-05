<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kantin Digital - Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --school-blue: #3b82f6;
            --school-green: #10b981;
            --school-orange: #fb923c;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--school-blue), var(--school-green), var(--school-orange));
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
                        <a class="nav-link" href="#menu">
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

    <!-- Hero Section -->
    <section class="hero-section py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Selamat Datang di Kantin Digital</h1>
            <p class="lead mb-4">Pesan makanan favoritmu dengan mudah dan cepat</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="#menu" class="btn btn-light btn-lg">
                    <i class="fas fa-utensils me-2"></i> Lihat Menu
                </a>
                <a href="{{ route('cart.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i> Keranjang
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col">
                    <h2 class="fw-bold">Mengapa Kantin Digital?</h2>
                    <p class="text-muted">Sistem pemesanan makanan modern untuk sekolah</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-bolt fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Cepat & Mudah</h5>
                            <p class="card-text text-muted">Pesan makanan favoritmu hanya dengan beberapa klik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-credit-card fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">Pembayaran Digital</h5>
                            <p class="card-text text-muted">Sistem pembayaran yang aman dan terintegrasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-clock fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">Hemat Waktu</h5>
                            <p class="card-text text-muted">Tidak perlu antri, waktu luang untuk belajar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Menu Hari Ini</h2>
                <p class="text-muted">Pilih makanan dan minuman favoritmu</p>
            </div>
            
            <div class="row g-4">
                <!-- Menu Cards -->
                @foreach($featuredProducts as $product)
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover h-100">
                        <img src="{{ asset('images/products/' . $product->slug . '.jpg') }}" 
                             class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <span class="badge bg-success mb-2">Tersedia</span>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ $product->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                                <button class="btn btn-school btn-sm" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                                    <i class="fas fa-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('menu.index') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-th-list me-2"></i> Lihat Semua Menu
                </a>
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

        // Debug functions
        window.showCart = () => {
            fetch('/cart')
                .then(response => response.text())
                .then(html => console.log('Cart page HTML:', html))
                .catch(error => console.error('Error:', error));
        };
    </script>
</body>
</html>
