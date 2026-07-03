<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\LaporanController as MahasiswaLaporan;
use App\Http\Controllers\Mahasiswa\NotifikasiController as MahasiswaNotifikasi;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasi;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;
use App\Http\Controllers\Staff\TugasController as StaffTugas;
use App\Http\Controllers\Staff\NotifikasiController as StaffNotifikasi;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUser;
use App\Http\Controllers\SuperAdmin\KategoriController as SuperAdminKategori;
use App\Http\Controllers\SuperAdmin\PengaturanController as SuperAdminPengaturan;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    $role = auth()->user()->role;
    return match($role) {
        'mahasiswa', 'dosen'            => redirect()->route('mahasiswa.dashboard'),
        'admin_prodi', 'admin_fakultas' => redirect()->route('admin.dashboard'),
        'staff'                         => redirect()->route('staff.dashboard'),
        'super_admin'                   => redirect()->route('superadmin.dashboard'),
        default                         => redirect()->route('login'),
    };
});

// ─── Auth ────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Mahasiswa & Dosen ───────────────────────────────────
Route::middleware(['auth', 'role:mahasiswa,dosen'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');

        // Laporan
        Route::get('/laporan', [MahasiswaLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/create', [MahasiswaLaporan::class, 'create'])->name('laporan.create');
        Route::post('/laporan', [MahasiswaLaporan::class, 'store'])->name('laporan.store');
        Route::get('/laporan/{laporan}', [MahasiswaLaporan::class, 'show'])->name('laporan.show');
        Route::post('/laporan/{laporan}/rating', [MahasiswaLaporan::class, 'submitRating'])->name('laporan.rating');
        Route::delete('/laporan/{laporan}', [MahasiswaLaporan::class, 'destroy'])->name('laporan.destroy');

        // Notifikasi
        Route::get('/notifikasi', [MahasiswaNotifikasi::class, 'index'])->name('notifikasi.index');
        Route::match(['get', 'post'], '/notifikasi/{id}/read', [MahasiswaNotifikasi::class, 'markRead'])->name('notifikasi.read');
        Route::post('/notifikasi/read-all', [MahasiswaNotifikasi::class, 'markAllRead'])->name('notifikasi.readAll');

        // Static
        Route::view('/panduan', 'mahasiswa.panduan')->name('panduan');
        Route::view('/faq', 'mahasiswa.faq')->name('faq');
    });

// ─── Admin Prodi / Fakultas ──────────────────────────────
Route::middleware(['auth', 'role:admin_prodi,admin_fakultas'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Laporan
        Route::get('/laporan', [AdminLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/{laporan}', [AdminLaporan::class, 'show'])->name('laporan.show');
        Route::post('/laporan/{laporan}/verifikasi', [AdminLaporan::class, 'verifikasi'])->name('laporan.verifikasi');
        Route::post('/laporan/{laporan}/tolak', [AdminLaporan::class, 'tolak'])->name('laporan.tolak');
        Route::post('/laporan/{laporan}/assign', [AdminLaporan::class, 'assign'])->name('laporan.assign');

        // Notifikasi
        Route::get('/notifikasi', [AdminNotifikasi::class, 'index'])->name('notifikasi.index');
        Route::match(['get', 'post'], '/notifikasi/{id}/read', [AdminNotifikasi::class, 'markRead'])->name('notifikasi.read');
        Route::post('/notifikasi/read-all', [AdminNotifikasi::class, 'markAllRead'])->name('notifikasi.readAll');
    });

// ─── Staff / Teknisi ─────────────────────────────────────
Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');

        // Tugas
        Route::get('/tugas', [StaffTugas::class, 'index'])->name('tugas.index');
        Route::get('/tugas/{laporan}', [StaffTugas::class, 'show'])->name('tugas.show');
        Route::post('/tugas/{laporan}/selesai', [StaffTugas::class, 'selesai'])->name('tugas.selesai');

        // Notifikasi
        Route::get('/notifikasi', [StaffNotifikasi::class, 'index'])->name('notifikasi.index');
        Route::match(['get', 'post'], '/notifikasi/{id}/read', [StaffNotifikasi::class, 'markRead'])->name('notifikasi.read');
        Route::post('/notifikasi/read-all', [StaffNotifikasi::class, 'markAllRead'])->name('notifikasi.readAll');
    });

// ─── Super Admin ─────────────────────────────────────────
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');

        // User
        Route::get('/users', [SuperAdminUser::class, 'index'])->name('users.index');
        Route::get('/users/create', [SuperAdminUser::class, 'create'])->name('users.create');
        Route::post('/users', [SuperAdminUser::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [SuperAdminUser::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [SuperAdminUser::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [SuperAdminUser::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-aktif', [SuperAdminUser::class, 'toggleAktif'])->name('users.toggleAktif');

        // Kategori
        Route::get('/kategori', [SuperAdminKategori::class, 'index'])->name('kategori.index');
        Route::get('/kategori/create', [SuperAdminKategori::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [SuperAdminKategori::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [SuperAdminKategori::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [SuperAdminKategori::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [SuperAdminKategori::class, 'destroy'])->name('kategori.destroy');

        // Pengaturan
        Route::get('/pengaturan', [SuperAdminPengaturan::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [SuperAdminPengaturan::class, 'update'])->name('pengaturan.update');
    });