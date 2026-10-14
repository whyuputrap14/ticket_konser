<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# tiket_konser - Aplikasi Pemesanan tiket (Laravel)

Aplikasi pemesanan tiket berbasis web yang dibangun menggunakan framework **Laravel 13**, **Tailwind CSS**, dan **MySQL**. Aplikasi ini dirancang untuk memudahkan pelanggan dalam memesan tiket secara digital serta memudahkan admin/kasir dalam mengelola menu dan merekap pesanan masuk secara real-time.

---

## 🚀 Fitur Utama

### 📱 Sisi Pelanggan (Customer)
- **Katalog Menu Interaktif:** Menampilkan daftar musik,festival,seminar
- **Filter Kategori:** Memfilter tampilan menu berdasarkan kategori event
- **Form Pemesanan:** Input nama pemesan, email, serta penentuan jumlah tiket.
- **Modal Konfirmasi:** Ringkasan pesanan dan kalkulasi total harga otomatis sebelum pesanan dikirim.

### 🛠️ Sisi Admin (Dashboard Kasir/Pengelola)
- **Rekap Pesanan Masuk:** Menampilkan daftar pesanan pelanggan lengkap dengan detail item, nomor meja, total harga, dan status.
- **Update Status Pesanan:** Mengubah status pesanan secara instan (*Pending*, *Selesai / Lunas*, *Batalkan*).
- **CRUD Master event:** Tambah, lihat, edit, dan hapus data menu konser beserta unggah foto menu.


---

## 🛠️ Perkakas & Teknologi (Tech Stack)

- **Framework PHP:** Laravel 13.x
- **PHP Version:** 8.3.x
- **Database:** MySQL
- **Frontend / Styling:** Tailwind CSS & Vite
- **Authentication:** Laravel Breeze

---

## 📖 Panduan Pembuatan Aplikasi (Step-by-Step)

### 1. Inisialisasi Project & Database

1. Buat project Laravel baru lewat terminal:
   ```bash
   composer create-project laravel/laravel praserkom_wahyu
   cd praserkom_wahyu

2. Konfigurasi file .env untuk menyambungkan ke database MySQL:

Cuplikan kode
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_ticket_konser
DB_USERNAME=root
DB_PASSWORD=

3. Migration, Model, dan Seeder
Jalankan perintah berikut di terminal untuk membuat Model, Migration, Controller, dan Seeder:
php artisan make:model Event -mcr
php artisan make:model Order -mcr
php artisan make:model OrderDetail -m
php artisan make:seeder EventSeeder

A. Database Migrations
database/migrations/xxxx_xx_xx_create_event_table.php
public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->enum('category', ['Musik', 'Seminar', 'Festival']);
        $table->integer('price');
        $table->text('description');
        $table->string('image')->nullable();
        $table->timestamps();
    });
}
database/migrations/xxxx_xx_xx_create_orders_table.php
public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('table_number');
        $table->integer('total_price');
        $table->string('status')->default('Pending');
        $table->timestamps();
    });
}
database/migrations/xxxx_xx_xx_create_order_details_table.php
public function up(): void
{
    Schema::create('order_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('events_id')->constrained('events')->onDelete('cascade');
        $table->integer('quantity');
        $table->integer('subtotal');
        $table->timestamps();
    });
}
PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $guarded = ['id'];
}
app/Models/Order.php

PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
app/Models/OrderDetail.php

PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
C. Database Seeder
database/seeders/EventSeeder.php

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert ([
            [
                'title' => 'Konser The Weeknd',
                'category' => 'Musik',
                'ticket_price' => 700000,
                'description' => 'Konser musik The Weeknd yang akan diadakan di Jakarta pada bulan Desember 2026. Nikmati penampilan spektakuler dari penyanyi terkenal ini.',
                'image' => null,
            ],
            [
                'title' => 'Festival Coachella',
                'category' => 'Festival',
                'ticket_price' => 1000000,
                'description' => 'Festival musik terbesar di dunia yang akan diadakan di Los Angeles pada bulan April 2026. Nikmati penampilan spektakuler dari berbagai artis terkenal.',
                'image' => null,
            ],
            [
                'title' => 'Seminar Elon Musk SpaceX Future',
                'category' => 'Seminar',
                'ticket_price' => 200000,
                'description' => 'Seminar tentang masa depan eksplorasi luar angkasa yang akan diadakan di San Francisco pada bulan Juni 2026. Dapatkan wawasan langsung dari Elon Musk dan tim SpaceX.',
                'image' => null,
            ],
            [
                'title' => 'Konser Coldplay',
                'category' => 'Musik',
                'ticket_price' => 800000,
                'description' => 'Konser musik Coldplay yang akan diadakan di Jakarta pada bulan November 2026. Nikmati penampilan spektakuler dari band terkenal ini.',
                'image' => null,
            ],
            [
                'title' => 'Festival Glastonbury',
                'category' => 'Festival',
                'ticket_price' => 1200000,
                'description' => 'Festival musik terbesar di Inggris yang akan diadakan di Glastonbury pada bulan Juni 2026. Nikmati penampilan spektakuler dari berbagai artis terkenal.',
                'image' => null,
            ]
        ]);
    }
}

Eksekusi migrasi dan penyemaian data:

Bash
composer dump-autoload
php artisan migrate:fresh --seed
3. Otentikasi Admin & CRUD event
Install Laravel Breeze untuk sistem login admin:

Bash
composer require laravel/breeze --dev
php artisan breeze:install blade
Hubungkan folder penyimpanan gambar dan kompilasi aset frontend:

Bash
php artisan storage:link
npm install
npm run build
Buat file tampilan Blade untuk CRUD event di folder resources/views/admin/events/:

index.blade.php (Tabel Kelola event)

create.blade.php (Form Tambah event)

edit.blade.php (Form Edit event)

4. Routing Arah Sistem (routes/web.php)
Daftarkan seluruh rute halaman pelanggan dan halaman terproteksi admin di file routes/web.php:

PHP
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\eventController;
use App\Http\Controllers\OrderController;

// 1. Halaman Utama Customer (Katalog & Checkout)
Route::get('/', [OrderController::class, 'index'])->name('customer.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');

// 2. Redirect Dashboard Breeze ke Rekap Pesanan Admin
Route::get('/dashboard', [OrderController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Grup Rute Admin (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    // Resource Route CRUD event
    Route::resource('/admin/events', eventController::class);
});

require __DIR__.'/auth.php';
💻 Cara Menjalankan Project di Lokal
Pastikan server MySQL di XAMPP / Laragon sudah aktif.

Jalankan server lokal Laravel (Terminal 1):

Bash
php artisan serve
Jalankan Vite untuk penanganan Tailwind CSS (Terminal 2):

Bash
npm run dev
Buka alamat berikut di browser:

Menu Pelanggan: http://127.0.0.1:8000/

Login Admin: http://127.0.0.1:8000/login

🔑 Kredensial Akun Admin
Email: admin@gmail.com

Password: password123
