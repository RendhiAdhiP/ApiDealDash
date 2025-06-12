# ApiDealDash - Backend Documentation

Repository: [https://github.com/RendhiAdhiP/ApiDealDash](https://github.com/RendhiAdhiP/ApiDealDash)

## 📌 Teknologi
- Laravel 11
- MySQL / PostgreSQL
- Laravel Storage
- Sanctum (opsional)

## 📋 Fitur Utama

### 🔐 Autentikasi
- Login & Logout
- Validasi email & password
- Menyimpan sesi login

### 👤 Manajemen User
- Tambah, edit, hapus, dan lihat detail user
- Atribut: nama, foto, email, password, tanggal lahir, kota asal, role

### 🏙️ Manajemen Kota
- CRUD kota
- Menyimpan nama kota

### 📦 Manajemen Produk
- CRUD produk
- Menyimpan nama produk, gambar, stok, dan total penjualan

### 🧮 Manajemen Stok Produk
- Tambah stok produk
- Riwayat penambahan stok berdasarkan tanggal

### 🧾 Manajemen Role
- Daftar role:
  - Superadmin
  - Admin Create
  - Admin View
  - Sales
- Role sudah dibuat saat project pertama kali dijalankan

## 🛡️ Hak Akses Berdasarkan Role

| Fitur               | Superadmin | Admin Create | Admin View | Sales |
|--------------------|------------|--------------|------------|-------|
| Manajemen User     | ✅          | ✅            | ✅ (view)   | ❌     |
| Manajemen Kota     | ✅          | ✅            | ✅          | ❌     |
| Manajemen Produk   | ✅          | ✅            | ✅          | ✅     |
| Stok Produk        | ✅          | ✅            | ✅          | ✅     |
| Role               | ✅          | ✅            | ✅          | ❌     |

## ⚙️ Cara Install Lokal

```bash
# 1. Clone repository
git clone https://github.com/RendhiAdhiP/ApiDealDash.git
cd ApiDealDash

# 2. Install dependency
composer install

# 3. Copy env & konfigurasi
cp .env.example .env
php artisan key:generate

# 4. Setup database di .env
DB_DATABASE=namadb
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi dan seeder
php artisan migrate --seed

# 6. Jalankan server
php artisan serve
