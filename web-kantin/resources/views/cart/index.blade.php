<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang - Kantin Digital</title>
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
        
        .cart-item {
            transition: all 0.3s;
        }
        
        .cart-item:hover {
            background-color: #f8f9fa;
        }
        
        .price-display {
            font-weight: bold;
            color: var(--school-green);
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
                        <a class="nav-link" href="{{ route('menu.index') }}">
                            <i class="fas fa-utensils me-1"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link active" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i> Keranjang
                            <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
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
            <h1 class="display-5 fw-bold mb-3">Keranjang Belanja</h1>
            <p class="lead">Kelola pesanan Anda sebelum checkout</p>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Daftar Produk
                                </h5>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary me-2" onclick="loadCart()">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="showDebugInfo()">
                                        <i class="fas fa-bug"></i> Debug
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="cartContent">
                                <!-- Cart will be rendered here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>
                                Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span id="subtotal">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Pajak (10%)</span>
                                    <span id="tax">Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span class="price-display" id="total">Rp 0</span>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" onclick="proceedToCheckout()" id="checkoutBtn" disabled>
                                    <i class="fas fa-credit-card me-2"></i>
                                    Lanjut ke Pembayaran
                                </button>
                                <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Lanjut Belanja
                                </a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = [];

        function loadCart() {
            console.log('=== LOAD CART START ===');
            try {
                const cartData = localStorage.getItem('cart');
                console.log('Raw cart data:', cartData);
                
                if (cartData) {
                    cart = JSON.parse(cartData);
                    console.log('Parsed cart:', cart);
                } else {
                    cart = [];
                    console.log('No cart data found, using empty array');
                }
                
                renderCart();
                updateSummary();
                updateCartBadge();
                
            } catch (error) {
                console.error('Error loading cart:', error);
                cart = [];
                renderCart();
            }
            console.log('=== LOAD CART END ===');
        }

        function renderCart() {
            console.log('=== RENDER CART START ===');
            console.log('Cart length:', cart.length);
            
            const cartContent = document.getElementById('cartContent');
            
            if (!cartContent) {
                console.error('Cart content element not found!');
                return;
            }
            
            if (cart.length === 0) {
                console.log('Cart is empty');
                cartContent.innerHTML = `
                    <div class="text-center p-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Keranjang Belanja Kosong</h4>
                        <p class="text-muted">Belum ada produk di keranjang Anda</p>
                        <a href="{{ route('menu.index') }}" class="btn btn-school">
                            <i class="fas fa-utensils me-2"></i> Lihat Menu
                        </a>
                    </div>
                `;
                
                const checkoutBtn = document.getElementById('checkoutBtn');
                if (checkoutBtn) {
                    checkoutBtn.disabled = true;
                }
                
                console.log('=== RENDER CART END (EMPTY) ===');
                return;
            }
            
            console.log('Rendering cart items');
            let html = '';
            
            cart.forEach((item, index) => {
                console.log(`Item ${index}:`, item);
                const itemTotal = item.price * item.quantity;
                
                html += `
                    <div class="cart-item p-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="https://via.placeholder.com/80x80/3b82f6/ffffff?text=${item.name.charAt(0).toUpperCase()}" 
                                     class="img-fluid rounded" alt="${item.name}">
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">${item.name}</h6>
                                <small class="text-muted">Rp ${item.price.toLocaleString('id-ID')}</small>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="updateQuantity(${index}, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="fw-bold mx-2">${item.quantity}</span>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="updateQuantity(${index}, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <h6 class="price-display mb-2">Rp ${itemTotal.toLocaleString('id-ID')}</h6>
                                <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            cartContent.innerHTML = html;
            
            const checkoutBtn = document.getElementById('checkoutBtn');
            if (checkoutBtn) {
                checkoutBtn.disabled = false;
            }
            
            console.log('=== RENDER CART END (SUCCESS) ===');
        }

        function updateQuantity(index, change) {
            console.log(`Updating quantity for item ${index} by ${change}`);
            
            cart[index].quantity += change;
            
            if (cart[index].quantity <= 0) {
                removeItem(index);
                return;
            }
            
            saveCart();
        }

        function removeItem(index) {
            console.log(`Removing item ${index}`);
            const itemName = cart[index].name;
            cart.splice(index, 1);
            saveCart();
            console.log(`Removed ${itemName} from cart`);
        }

        function saveCart() {
            console.log('Saving cart to localStorage');
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateSummary();
            updateCartBadge();
        }

        function updateSummary() {
            const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('tax').textContent = `Rp ${tax.toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function updateCartBadge() {
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            const badge = document.getElementById('cartBadge');
            
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        function proceedToCheckout() {
            if (cart.length === 0) {
                alert('Keranjang belanja masih kosong');
                return;
            }
            alert('Checkout functionality will be implemented');
        }

        function showDebugInfo() {
            console.log('=== DEBUG INFO ===');
            console.log('Cart array:', cart);
            console.log('Cart length:', cart.length);
            console.log('LocalStorage:', {
                exists: 'cart' in localStorage,
                raw: localStorage.getItem('cart'),
                parsed: JSON.parse(localStorage.getItem('cart') || '[]')
            });
            console.log('=== END DEBUG ===');
            
            alert(`Debug info logged to console. Cart has ${cart.length} items.`);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Cart page loaded');
            loadCart();
        });

        // Listen for storage changes
        window.addEventListener('storage', function(e) {
            if (e.key === 'cart') {
                console.log('Storage changed, reloading cart');
                loadCart();
            }
        });

        // Debug functions
        window.loadCart = loadCart;
        window.showDebugInfo = showDebugInfo;
        window.clearCart = function() {
            localStorage.removeItem('cart');
            cart = [];
            loadCart();
        };
        window.addTestItem = function() {
            const testItem = {
                id: Date.now(),
                name: 'Test Product',
                price: 10000,
                quantity: 1
            };
            cart.push(testItem);
            saveCart();
        };
    </script>
</body>
</html>
