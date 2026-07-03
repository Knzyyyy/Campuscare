<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'ikon',
        'warna',
        'fakultas_id',
        'estimasi_hari',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'estimasi_hari' => 'integer',
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke fakultas pemilik kategori (null = kategori global).
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Relasi ke laporan dalam kategori ini.
     */
    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    /**
     * Relasi ke staff yang menangani kategori ini (pivot staff_kategoris).
     */
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'staff_kategoris', 'kategori_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Scope: hanya kategori yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: kategori global (tidak terikat fakultas tertentu).
     */
    public function scopeGlobal(Builder $query): Builder
    {
        return $query->whereNull('fakultas_id');
    }

    /**
     * Scope: kategori untuk fakultas tertentu (termasuk kategori global).
     */
    public function scopeForFakultas(Builder $query, int $fakultasId): Builder
    {
        return $query->where(function (Builder $q) use ($fakultasId) {
            $q->whereNull('fakultas_id')
                ->orWhere('fakultas_id', $fakultasId);
        });
    }
}
