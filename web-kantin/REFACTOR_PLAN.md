# 🔧 REFACTOR PLAN - KANTIN DIGITAL SEKOLAH

## 📊 STATUS AUDIT

### ✅ YANG SUDAH BAIK
- ✅ Laravel 12 + PHP 8.2 + Tailwind CSS 4
- ✅ Database migrations dengan foreign keys
- ✅ Models dengan relationships
- ✅ Cart system menggunakan session (guest-friendly)

### ❌ BUG & MASALAH YANG DITEMUKAN

#### 1. DATABASE MISMATCH
- ❌ Tabel `transactions` butuh `user_id` (login required)
- ❌ Tidak ada tabel `orders` untuk guest checkout
- ❌ Tidak ada field: `customer_name`, `customer_class`, `order_number`, `status` (Menunggu/Diproses/Siap/Selesai)
- ❌ Tabel `schools`, `topups`, `notifications` tidak diperlukan
- ❌ Field `saldo` di users tidak diperlukan
- ❌ `.env` menggunakan SQLite, requirements MySQL

#### 2. CONTROLLER BUGS
- ❌ `CartController::processCheckout()` tidak save ke database
- ❌ Tidak ada database transaction (race condition risk)
- ❌ Tidak ada validasi stok saat checkout
- ❌ Payment method tidak sesuai (ada saldo/qris/transfer)

#### 3. ROUTING ISSUES
- ❌ Checkout route butuh auth (line 88 web.php)
- ❌ Banyak route siswa tidak diperlukan (topup, saldo, notifications)
- ❌ API cart count format salah

#### 4. UI/UX PROBLEMS
- ❌ Design masih blue/green, bukan Amber/Orange theme
- ❌ Hardcoded products di view (tidak dari database)
- ❌ Tidak ada form nama + kelas di checkout
- ❌ Tidak ada halaman konfirmasi order
- ❌ Tidak ada dashboard penjual untuk manage orders

#### 5. SECURITY ISSUES
- ❌ Race condition: multiple checkout produk sama
- ❌ Tidak ada rollback jika checkout gagal
- ❌ Stok bisa minus

---

## 🎯 RENCANA PERBAIKAN

### FASE 1: DATABASE RESTRUCTURE ✅
1. ✅ Buat migration `create_orders_table` (guest-friendly)
2. ✅ Buat migration `create_order_items_table`
3. ✅ Update `.env.example` ke MySQL
4. ✅ Buat seeder untuk categories & products

### FASE 2: MODELS & BUSINESS LOGIC
1. ✅ Buat `Order` model dengan relationships
2. ✅ Buat `OrderItem` model
3. ✅ Refactor `CartController::processCheckout()` dengan:
   - Database transaction
   - Validasi stok
   - Save order + order items
   - Kurangi stok produk
   - Generate order number
4. ✅ Buat `OrderController` untuk penjual

### FASE 3: ROUTING CLEANUP
1. ✅ Hapus auth middleware dari checkout
2. ✅ Hapus routes yang tidak diperlukan (topup, saldo, dll)
3. ✅ Fix API cart count response
4. ✅ Tambah routes untuk order management

### FASE 4: UI OVERHAUL - AMBER/ORANGE THEME
1. ✅ Update `welcome.blade.php` dengan Amber theme
2. ✅ Update `menu/index.blade.php` dengan Amber theme + dynamic products
3. ✅ Update `cart/simple.blade.php` dengan Amber theme
4. ✅ Buat `cart/checkout.blade.php` dengan form nama + kelas
5. ✅ Buat `cart/confirmation.blade.php` untuk order success
6. ✅ Buat `admin/orders.blade.php` untuk penjual

### FASE 5: CLEANUP & OPTIMIZATION
1. ✅ Hapus migrations yang tidak diperlukan
2. ✅ Hapus views yang tidak dipakai
3. ✅ Update README.md dengan panduan setup
4. ✅ Buat seeder untuk demo data

---

## 🎨 DESIGN SYSTEM - ELEGANT WARM CANTEEN THEME

### Color Palette
```css
Primary: amber-500 (#f59e0b), amber-600 (#d97706)
Secondary: orange-500 (#f97316), orange-600 (#ea580c)
Accent: yellow-50 (#fefce8), amber-100 (#fef3c7)
Neutral: slate-700 (#334155), slate-900 (#0f172a)
Background: gradient from amber-50 to white
```

### Component Styles
- Button utama: `bg-gradient-to-r from-amber-500 to-orange-500 text-white`
- Hover: `from-amber-600 to-orange-600`
- Card menu: `bg-white shadow-lg rounded-xl border border-amber-200`
- Heading: `text-slate-900`

---

## 📦 DATABASE SCHEMA FINAL

### `orders` table
```
- id
- order_number (unique, e.g., ORD-20240305-0001)
- customer_name
- customer_class
- table_number (nullable)
- total_amount
- status (pending, processing, ready, completed, cancelled)
- notes (nullable)
- created_at
- updated_at
```

### `order_items` table
```
- id
- order_id (foreign key)
- product_id (foreign key)
- product_name (snapshot)
- product_price (snapshot)
- quantity
- subtotal
- created_at
- updated_at
```

### `products` table (existing, no changes needed)
### `categories` table (existing, no changes needed)
### `users` table (keep for admin/penjual only)

---

## ✅ CHECKLIST TESTING

### Functional Testing
- [ ] Guest bisa lihat menu
- [ ] Guest bisa tambah ke cart
- [ ] Guest bisa update quantity di cart
- [ ] Guest bisa hapus item dari cart
- [ ] Guest bisa checkout tanpa login
- [ ] Form checkout validasi nama + kelas
- [ ] Order number ter-generate otomatis
- [ ] Stok berkurang setelah checkout
- [ ] Stok tidak bisa minus
- [ ] Konfirmasi order tampil setelah checkout
- [ ] Penjual bisa lihat daftar order
- [ ] Penjual bisa update status order
- [ ] Admin bisa CRUD products
- [ ] Admin bisa CRUD categories

### Security Testing
- [ ] Race condition handled (database transaction)
- [ ] Stok validation di checkout
- [ ] XSS protection
- [ ] CSRF protection
- [ ] SQL injection protection

### UI/UX Testing
- [ ] Responsive di mobile
- [ ] Amber/Orange theme konsisten
- [ ] Loading states
- [ ] Error messages jelas
- [ ] Success messages jelas

---

## 🚀 PANDUAN MENJALANKAN PROJECT

### 1. Setup Environment
```bash
cp .env.example .env
# Edit .env: set DB_CONNECTION=mysql, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Generate Key & Run Migrations
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

### 4. Storage Link
```bash
php artisan storage:link
```

### 5. Run Development Server
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

### 6. Access Application
- Frontend: http://localhost:8000
- Admin: http://localhost:8000/admin/dashboard
- Default Admin: admin@kantin.com / password

---

## 📝 NOTES

- Project ini TIDAK menggunakan sistem login untuk customer
- Customer hanya perlu isi nama + kelas saat checkout
- Sistem saldo/topup DIHAPUS
- Payment gateway TIDAK diimplementasi (kantin sekolah sederhana)
- Focus: Simple, fast, reliable order management
