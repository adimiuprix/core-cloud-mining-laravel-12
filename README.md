# Core Cloud Mining Platform

Platform simulasi Cloud Mining aset digital (Point/Crypto) yang dibangun menggunakan **Laravel 12**. Platform ini menawarkan pengalaman penambangan real-time yang mulus dengan visualisasi balance yang diperbarui setiap milidetik di sisi client.

---

## 🚀 Fitur Utama

- **Real-time Mining Counter**: Pergerakan saldo yang sangat halus (60 FPS) menggunakan optimasi `requestAnimationFrame` tanpa membebani server.
- **Automated Balance Sync**: Sinkronisasi otomatis antara aktivitas mining di sisi client dengan database server setiap kali user berinteraksi dengan dashboard.
- **Mining Plans System**: Sistem paket mining yang fleksibel (Free & Paid) dengan durasi dan tingkat pendapatan (`earning rate`) yang berbeda.
- **Auto-Provisioning**: User baru secara otomatis mendapatkan paket "Free Plan" saat pertama kali mendaftar.
- **Plan Expiration Logic**: Sistem otomatis mendeteksi dan menonaktifkan paket yang telah melewati masa berlakunya.
- **Modern UI/UX**: Dibangun dengan **Tailwind CSS v4** untuk antarmuka yang modern, responsif, dan performa styling yang optimal.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Tailwind CSS v4, Vite, Blade Templates
- **Client Logic**: jQuery 4.0.0 & Vanilla JS (v_v)
- **Database**: MySQL / SQLite (mendukung Eloquent ORM)
- **Tooling**: Composer, NPM, Vite

---

## 💻 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di lingkungan lokal Anda:

1. **Clone Repository**
   ```bash
   git clone https://github.com/adimiuprix/core-cloud-mining-laravel-12.git
   cd tosun
   ```

2. **Install Dependensi Backend**
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Konfigurasi Lingkungan (`.env`)**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Migrasi dan Seed Database**
   Jalankan migrasi untuk membuat tabel dan mengisi data awal paket (plans).
   ```bash
   php artisan migrate --seed
   ```

6. **Menjalankan Aplikasi**
   Gunakan perintah berikut untuk menjalankan server development dan Vite secara bersamaan:
   ```bash
   npm run dev
   ```
   Aplikasi akan tersedia di `http://localhost:8000` (atau sesuai konfigurasi artisan serve).

---

## 📂 Struktur Project Penting

- `app/Models/User.php`: Logika inti perhitungan saldo (`syncBalance`) dan manajemen status plan.
- `app/Http/Controllers/DashboardController.php`: Orkestrator aktivitas background tugas sebelum merender tampilan.
- `resources/views/dashboard.blade.php`: Implementasi frontend untuk animasi real-time counter.
- `database/migrations/`: Definisi struktur tabel `plans` dan `user_mining_histories`.

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---
*Developed with ❤️ by Adimiuprix*
