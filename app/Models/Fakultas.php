<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fakultas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fakultas';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke program studi di bawah fakultas ini.
     */
    public function prodi(): HasMany
    {
        return $this->hasMany(Prodi::class);
    }

    /**
     * Relasi ke pengguna yang terdaftar di fakultas ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke kategori layanan khusus fakultas ini.
     */
    public function kategoris(): HasMany
    {
        return $this->hasMany(Kategori::class);
    }

    /**
     * Relasi ke laporan yang masuk ke scope fakultas ini.
     */
    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    /**
     * Scope: hanya fakultas yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
