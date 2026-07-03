<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prodi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prodi';

    protected $fillable = [
        'fakultas_id',
        'kode',
        'nama',
        'jenjang',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke fakultas induk.
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Relasi ke pengguna yang terdaftar di prodi ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke laporan yang masuk ke scope prodi ini.
     */
    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    /**
     * Scope: hanya prodi yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
