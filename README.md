# 🎓 CampusCare

**Sistem Informasi Pelaporan, Monitoring, dan Evaluasi Layanan Kampus**

CampusCare is a web-based campus service reporting and monitoring system designed for internal use by students, lecturers, staff, and administrators.

Built with Laravel 10 · MySQL · Tailwind CSS · Alpine.js · Chart.js

Features:
- 📋 Multi-role authentication (Mahasiswa, Dosen, Admin, Staff, Super Admin)
- 📝 Laporan masalah fasilitas kampus dengan upload foto
- 🔄 Real-time status tracking (Terkirim → Diverifikasi → Diproses → Selesai)
- 📊 Dashboard monitoring dengan grafik laporan
- 🔔 Sistem notifikasi in-app
- ⭐ Rating & feedback kepuasan layanan
- 📱 Responsive design (mobile-friendly dengan bottom navigation)

---

## 🚀 Tech Stack

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: Blade + Tailwind CSS + Alpine.js
- **Chart**: Chart.js

---

## ✨ Fitur Utama

- 🔐 Multi-role authentication (Mahasiswa, Dosen, Admin Prodi, Admin Fakultas, Staff, Super Admin)
- 📝 Buat laporan masalah fasilitas kampus dengan upload foto
- 🔄 Tracking status laporan real-time (Terkirim → Diverifikasi → Diproses → Selesai)
- 📊 Dashboard monitoring dengan grafik kategori laporan
- 🔔 Notifikasi in-app setiap ada update laporan
- ⭐ Rating & feedback kepuasan layanan
- 📱 Tampilan responsif (mobile-friendly dengan bottom navigation)

---

## ⚙️ Cara Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/Knzyyyy/Campuscare.git
cd Campuscare
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`, sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=campuscare
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database

Buat database baru di MySQL dengan nama `campuscare`, lalu jalankan:

```bash
php artisan migrate --seed
```

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
npm run build
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses: **http://127.0.0.1:8000**

---

## 👤 Akun Default (Setelah Seeding)

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@campuscare.id | password |
| Admin Fakultas | admin.fakultas@campuscare.id | password |
| Admin Prodi | admin.prodi@campuscare.id | password |
| Staff | staff@campuscare.id | password |
| Dosen | dosen@campuscare.id | password |
| Mahasiswa | mahasiswa@campuscare.id | password |

---

## 📁 Struktur Role & Akses

| Role | Akses |
|------|-------|
| **Mahasiswa / Dosen** | Buat laporan, lihat riwayat & status, beri rating |
| **Admin Prodi / Fakultas** | Verifikasi laporan, assign staff, dashboard monitoring |
| **Staff / Teknisi** | Update status laporan, upload bukti penyelesaian |
| **Super Admin** | Kelola semua data (user, kategori, pengaturan sistem) |

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
