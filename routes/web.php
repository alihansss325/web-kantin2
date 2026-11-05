<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

// Halaman Utama
Route::get('/', function () {
    $featuredProducts = \App\Models\Product::with('category')
        ->where('is_featured', true)
        ->where('status', 'available')
        ->limit(8)
        ->get();
    
    return view('welcome', compact('featuredProducts'));
})->name('welcome');

// Authentication Routes
Route::get('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Registration Routes
Route::get('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// Password Reset Routes
Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
    ->name('password.update');

// Email Verification Routes
Route::get('email/verify', [App\Http\Controllers\Auth\EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('email/verification-notification', [App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Password Confirmation Routes
Route::get('confirm-password', [App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('confirm-password', [App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

// Routes untuk Menu (Public - Tanpa Login)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/search', [MenuController::class, 'search'])->name('menu.search');
Route::get('/menu/featured', [MenuController::class, 'featured'])->name('menu.featured');
Route::get('/menu/{product}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/category/{category}', [MenuController::class, 'category'])->name('menu.category');

// Routes untuk Keranjang (Public - Tanpa Login)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Routes untuk Siswa
Route::middleware(['auth'])->group(function () {

    // Keranjang Belanja (Checkout butuh login)
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CartController::class, 'processCheckout'])->name('process');
    });

    // Dashboard Siswa
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');

    // Profile Siswa
    Route::get('/profile', function () {
        return view('siswa.profile');
    })->name('siswa.profile');

    // Transaksi Siswa
    Route::get('/transactions', function () {
        return view('siswa.transactions');
    })->name('siswa.transactions');

    // Top-up Saldo
    Route::get('/topup', function () {
        return view('siswa.topup');
    })->name('siswa.topup');

    // Notifications
    Route::get('/notifications', function () {
        return view('siswa.notifications');
    })->name('siswa.notifications');
});

// Routes untuk Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Sekolah
    Route::prefix('schools')->name('schools.')->group(function () {
        Route::get('/', [SchoolController::class, 'index'])->name('index');
        Route::get('/create', [SchoolController::class, 'create'])->name('create');
        Route::post('/', [SchoolController::class, 'store'])->name('store');
        Route::get('/{school}', [SchoolController::class, 'show'])->name('show');
        Route::get('/{school}/edit', [SchoolController::class, 'edit'])->name('edit');
        Route::put('/{school}', [SchoolController::class, 'update'])->name('update');
        Route::delete('/{school}', [SchoolController::class, 'destroy'])->name('destroy');
        Route::patch('/{school}/toggle', [SchoolController::class, 'toggleStatus'])->name('toggle');
    });

    // Manajemen Kategori Menu
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::patch('/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('toggle');
    });

    // Manajemen Menu/Produk
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::patch('/{product}/toggle', [ProductController::class, 'toggleStatus'])->name('toggle');
        Route::patch('/{product}/featured', [ProductController::class, 'toggleFeatured'])->name('featured');
        Route::put('/{product}/stock', [ProductController::class, 'stockUpdate'])->name('stock');
    });

    // Pengaturan Toko
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/hours', [SettingsController::class, 'updateHours'])->name('admin.settings.hours');

    // Laporan & Analytics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', function () {
            return view('admin.reports.sales');
        })->name('sales');
        
        Route::get('/inventory', function () {
            return view('admin.reports.inventory');
        })->name('inventory');
        
        Route::get('/transactions', function () {
            return view('admin.reports.transactions');
        })->name('transactions');
        
        Route::get('/topups', function () {
            return view('admin.reports.topups');
        })->name('topups');
    });

    // Manajemen Transaksi
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', function () {
            return view('admin.transactions.index');
        })->name('index');
    });

    // Manajemen Siswa
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', function () {
            return view('admin.students.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('admin.students.create');
        })->name('create');
        
        Route::post('/', function () {
            // Store student logic
            return redirect()->route('admin.students.index');
        })->name('store');
        
        Route::get('/{user}', function ($user) {
            return view('admin.students.show', compact('user'));
        })->name('show');
        
        Route::get('/{user}/edit', function ($user) {
            return view('admin.students.edit', compact('user'));
        })->name('edit');
        
        Route::put('/{user}', function ($user) {
            // Update student logic
            return redirect()->route('admin.students.index');
        })->name('update');
        
        Route::delete('/{user}', function ($user) {
            // Delete student logic
            return redirect()->route('admin.students.index');
        })->name('destroy');
    });

    // Top-up Management
    Route::prefix('topups')->name('topups.')->group(function () {
        Route::get('/', function () {
            return view('admin.topups.index');
        })->name('index');
        
        Route::post('/{topup}/approve', function ($topup) {
            // Approve topup logic
            return back();
        })->name('approve');
        
        Route::post('/{topup}/reject', function ($topup) {
            // Reject topup logic
            return back();
        })->name('reject');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function () {
            return view('admin.settings.general');
        })->name('general');
        
        Route::put('/general', function () {
            // Update general settings
            return back();
        })->name('general.update');
        
        Route::get('/financial', function () {
            return view('admin.settings.financial');
        })->name('financial');
        
        Route::put('/financial', function () {
            // Update financial settings
            return back();
        })->name('financial.update');
    });
});

// API Routes untuk AJAX requests (Public - Tanpa Login)
Route::prefix('api')->name('api.')->group(function () {
    // Cart API
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('cart.total');
    
    // Product API
    Route::get('/products/search', function (Request $request) {
        $search = $request->get('q');
        $products = App\Models\Product::where('name', 'like', "%{$search}%")
            ->available()
            ->limit(10)
            ->get(['id', 'name', 'price', 'image']);
        
        return response()->json($products);
    })->name('products.search');
});

// API Routes untuk AJAX requests (Butuh Login)
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    // Notifications API
    Route::get('/notifications/unread', function () {
        $count = auth()->user()->getUnreadNotificationsCount();
        return response()->json(['count' => $count]);
    })->name('notifications.unread');
});

// Error Routes
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
