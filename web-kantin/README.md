# 🍽️ Kantin Digital Sekolah

Website sistem pemesanan makanan di kantin sekolah agar siswa bisa memesan makanan sebelum jam istirahat tanpa perlu antre.

## 🎨 Design System - Elegant Warm Canteen Theme

### Color Palette
- **Primary**: Amber (amber-500, amber-600)
- **Secondary**: Orange (orange-500, orange-600)
- **Accent**: Cream (yellow-50, amber-100)
- **Neutral**: Slate (slate-700, slate-900)
- **Background**: Gradient dari amber-50 → white

## 👥 Role Sistem

### 1. Admin / Penjual Kantin
- Dashboard penjual
- CRUD menu makanan dan minuman
- Upload gambar menu
- Mengatur harga dan stok
- Melihat pesanan yang masuk
- Mengubah status pesanan (Menunggu → Diproses → Siap Diambil → Selesai)
- Melihat total penjualan harian

### 2. Customer (Guest / Tanpa Akun)
- Melihat daftar menu
- Filter menu berdasarkan kategori
- Menambahkan menu ke cart
- Mengubah jumlah pesanan
- Checkout tanpa login
- Mengisi data: nama, kelas
- Mendapat nomor pesanan

## ✨ Fitur Utama

### Customer Features
- ✅ Browse menu tanpa login
- ✅ Add to cart dengan validasi stok
- ✅ Guest checkout (hanya isi nama + kelas)
- ✅ Nomor pesanan otomatis
- ✅ Halaman konfirmasi pesanan
- ✅ Responsive design

### Admin Features
- ✅ Kelola menu (CRUD)
- ✅ Kelola kategori
- ✅ Kelola pesanan
- ✅ Update status pesanan
- ✅ Dashboard statistik
- ✅ Cetak struk pesanan

## 🚀 Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: MySQL (via phpMyAdmin)
- **Frontend**: Tailwind CSS 4
- **Icons**: Font Awesome 6

## 📦 Database Schema

### `orders` table
```sql
- id
- order_number (unique, e.g., ORD-20240305-0001)
- customer_name
- customer_class
- table_number (nullable)
- total_amount
- status (pending, processing, ready, completed, cancelled)
- notes (nullable)
- created_at, updated_at
```

### `order_items` table
```sql
- id
- order_id (foreign key)
- product_id (foreign key)
- product_name (snapshot)
- product_price (snapshot)
- quantity
- subtotal
- created_at, updated_at
```

### `products` table
```sql
- id, name, slug, category_id
- description, price, cost_price
- stock, min_stock, unit
- image, barcode, status
- is_featured, is_taxable, tax_percentage
- sort_order, created_at, updated_at
```

### `categories` table
```sql
- id, name, slug, description
- icon, color, sort_order
- is_active, created_at, updated_at
```

## 🛠️ Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd kantin-digital
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
```

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin_digital
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Create Database
Buat database `kantin_digital` di phpMyAdmin atau MySQL:
```sql
CREATE DATABASE kantin_digital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Run Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
npm run build
```

### 9. Run Development Server
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Dev Server (optional, for development)
npm run dev
```

### 10. Access Application
- **Frontend**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin/dashboard
- **Login Admin**:
  - Email: `admin@kantin.com`
  - Password: `password`

## 📁 Project Structure

```
kantin-digital/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   └── CategoryController.php
│   │   │   ├── CartController.php
│   │   │   └── MenuController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Product.php
│       ├── Category.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── 2024_03_05_000001_create_orders_table.php
│   │   ├── 2024_03_05_000002_create_order_items_table.php
│   │   └── ...
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── menu/
│       │   └── index.blade.php
│       ├── cart/
│       │   ├── index.blade.php
│       │   ├── checkout.blade.php
│       │   └── confirmation.blade.php
│       ├── admin/
│       │   ├── orders/
│       │   │   └── index.blade.php
│       │   └── products/
│       │       └── index.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php
└── public/
    ├── images/
    │   └── products/
    └── storage/
        └── products/
```

## 🔐 Default Credentials

### Admin / Penjual Kantin
- Email: `admin@kantin.com`
- Password: `password`

## 🎯 Usage Flow

### Customer Flow
1. Buka website → Lihat menu
2. Pilih menu → Tambah ke keranjang
3. Lihat keranjang → Checkout
4. Isi nama + kelas → Konfirmasi
5. Dapat nomor pesanan → Tunggu panggilan

### Admin Flow
1. Login → Dashboard
2. Lihat pesanan masuk
3. Update status: Menunggu → Diproses → Siap Diambil
4. Panggil customer saat pesanan siap
5. Selesaikan pesanan

## 🧪 Testing Checklist

### Functional Testing
- [x] Guest bisa lihat menu
- [x] Guest bisa tambah ke cart
- [x] Guest bisa update quantity di cart
- [x] Guest bisa hapus item dari cart
- [x] Guest bisa checkout tanpa login
- [x] Form checkout validasi nama + kelas
- [x] Order number ter-generate otomatis
- [x] Stok berkurang setelah checkout
- [x] Stok tidak bisa minus (validasi)
- [x] Konfirmasi order tampil setelah checkout
- [x] Admin bisa lihat daftar order
- [x] Admin bisa update status order
- [x] Admin bisa CRUD products
- [x] Admin bisa CRUD categories

### Security Features
- [x] Database transaction untuk checkout
- [x] Row locking untuk prevent race condition
- [x] Stock validation
- [x] CSRF protection
- [x] XSS protection
- [x] SQL injection protection (Eloquent ORM)

## 🚫 Fitur yang TIDAK Ada

Sesuai requirements, fitur berikut TIDAK diimplementasi:
- ❌ Login customer
- ❌ Payment gateway
- ❌ Sistem pengiriman
- ❌ Voucher/diskon
- ❌ Affiliate
- ❌ Chat system
- ❌ Sistem saldo/topup
- ❌ Notifikasi push

## 📝 Notes

- Project ini fokus pada simplicity dan reliability
- Customer TIDAK perlu membuat akun
- Checkout hanya perlu nama + kelas
- Sistem ini cocok untuk kantin sekolah kecil-menengah
- Database menggunakan InnoDB dengan foreign keys
- Semua operasi checkout menggunakan database transaction

## 🐛 Bug Fixes & Improvements

### Fixed Issues
1. ✅ Cart system sekarang guest-friendly
2. ✅ Checkout tidak memerlukan login
3. ✅ Database transaction untuk atomic operations
4. ✅ Stock validation dengan row locking
5. ✅ Order number auto-generation
6. ✅ Proper error handling
7. ✅ Amber/Orange theme implementation
8. ✅ Responsive design
9. ✅ API cart count returns proper JSON
10. ✅ Removed unnecessary features (saldo, topup, etc)

## 📞 Support

Jika ada pertanyaan atau issue, silakan buat issue di repository ini.

## 📄 License

MIT License

---

**Developed with ❤️ for Indonesian School Canteens**
