# Ticket Konser

Aplikasi web pemesanan tiket event berbasis Laravel. Pelanggan dapat melihat katalog dan memesan tiket; pengguna yang sudah login dapat mengelola event dan memantau pesanan.

## Fitur

- Katalog event dengan filter kategori Musik, Festival, dan Seminar.
- Checkout tiket dengan nama dan email pemesan.
- Dashboard pesanan dengan rincian tiket dan total harga.
- Pembaruan status pesanan: Pending, Confirmed, dan Cancelled.
- CRUD event termasuk unggah gambar.
- Login, registrasi, dan pengelolaan profil menggunakan Laravel Breeze.

## Teknologi

- PHP 8.3 atau lebih baru
- Laravel 13
- MySQL atau SQLite
- Node.js dan npm untuk aset frontend
- Tailwind CSS dan Vite

## Menjalankan di Windows (PowerShell)

Pastikan PHP, Composer, Node.js, dan npm tersedia di PowerShell. Untuk MySQL, nyalakan layanan database terlebih dahulu.

```powershell
Set-Location "C:\laragon\www\praserkom_wahyu"
composer install
Copy-Item .env.example .env
php artisan key:generate
```

File `.env` berisi konfigurasi lokal dan tidak boleh diunggah ke GitHub.

### Menggunakan SQLite (konfigurasi bawaan)

Konfigurasi `.env.example` sudah menggunakan SQLite. Buat file database jika belum tersedia:

```powershell
if (-not (Test-Path "database\database.sqlite")) {
    New-Item -ItemType File "database\database.sqlite"
}
```

### Menggunakan MySQL

Buat database kosong, lalu sesuaikan bagian database di `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticket_konser
DB_USERNAME=root
DB_PASSWORD=
```

### Migrasi, seed data, dan aset frontend

```powershell
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
```

Seeder membuat beberapa event contoh dan akun demo. Untuk mengulang seluruh migrasi dan data seed di database **pengembangan saja** (perintah ini menghapus tabel/data yang ada):

```powershell
php artisan migrate:fresh --seed
```

### Menjalankan aplikasi

```powershell
php artisan serve
```

Buka <http://127.0.0.1:8000>. Untuk pengembangan frontend dengan hot reload, jalankan `npm run dev` di terminal PowerShell kedua.

## Akun demo lokal

Setelah menjalankan seeder:

- Email: `admin@gmail.com`
- Password: `admin123`

Kredensial tersebut hanya untuk pengembangan lokal. Ganti atau hapus akun demo sebelum aplikasi digunakan di lingkungan publik/produksi; jangan gunakan password contoh sebagai kredensial produksi.

## Pengujian

Jalankan seluruh test dengan:

```powershell
php artisan test
```

