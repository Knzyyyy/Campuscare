<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const ROLE_MAHASISWA = 'mahasiswa';

    public const ROLE_DOSEN = 'dosen';

    public const ROLE_ADMIN_PRODI = 'admin_prodi';

    public const ROLE_ADMIN_FAKULTAS = 'admin_fakultas';

    public const ROLE_STAFF = 'staff';

    public const ROLE_SUPER_ADMIN = 'super_admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'nip',
        'phone',
        'avatar',
        'fakultas_id',
        'prodi_id',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Relasi ke fakultas pengguna.
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Relasi ke program studi pengguna.
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    /**
     * Relasi ke laporan yang dibuat pengguna sebagai pelapor.
     */
    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class, 'user_id');
    }

    /**
     * Relasi ke laporan yang ditugaskan ke staff ini.
     */
    public function laporansDitugaskan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'assigned_staff_id');
    }

    /**
     * Relasi ke laporan yang diverifikasi oleh admin ini.
     */
    public function laporansDiverifikasi(): HasMany
    {
        return $this->hasMany(Laporan::class, 'verified_by');
    }

    /**
     * Relasi ke laporan yang diproses oleh staff ini.
     */
    public function laporansDiproses(): HasMany
    {
        return $this->hasMany(Laporan::class, 'processed_by');
    }

    /**
     * Relasi ke notifikasi pengguna.
     */
    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Relasi ke riwayat perubahan status yang dilakukan pengguna.
     */
    public function laporanStatusLogs(): HasMany
    {
        return $this->hasMany(LaporanStatusLog::class);
    }

    /**
     * Relasi ke file lampiran yang diunggah pengguna.
     */
    public function laporanLampirans(): HasMany
    {
        return $this->hasMany(LaporanLampiran::class, 'uploaded_by');
    }

    /**
     * Relasi ke kategori yang ditangani staff (pivot staff_kategoris).
     */
    public function kategoriStaff(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'staff_kategoris', 'user_id', 'kategori_id')
            ->withTimestamps();
    }

    /**
     * Cek apakah pengguna berperan sebagai mahasiswa.
     */
    public function isMahasiswa(): bool
    {
        return $this->role === self::ROLE_MAHASISWA;
    }

    /**
     * Cek apakah pengguna berperan sebagai dosen.
     */
    public function isDosen(): bool
    {
        return $this->role === self::ROLE_DOSEN;
    }

    /**
     * Cek apakah pengguna berperan sebagai admin (prodi atau fakultas).
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN_PRODI, self::ROLE_ADMIN_FAKULTAS], true);
    }

    /**
     * Cek apakah pengguna berperan sebagai admin fakultas.
     */
    public function isAdminFakultas(): bool
    {
        return $this->role === self::ROLE_ADMIN_FAKULTAS;
    }

    /**
     * Cek apakah pengguna berperan sebagai staff/teknisi.
     */
    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    /**
     * Cek apakah pengguna berperan sebagai super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Accessor: URL avatar pengguna atau inisial nama sebagai fallback.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->avatar) {
                return Storage::url($this->avatar);
            }

            $kata = explode(' ', trim($this->name));
            $inisial = '';

            foreach (array_slice($kata, 0, 2) as $bagian) {
                $inisial .= mb_strtoupper(mb_substr($bagian, 0, 1));
            }

            return $inisial ?: '?';
        });
    }
}
