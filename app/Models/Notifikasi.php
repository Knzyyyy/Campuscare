<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasis';

    protected $fillable = [
        'user_id',
        'laporan_id',
        'judul',
        'pesan',
        'tipe',
        'url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'tipe' => 'string',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relasi ke penerima notifikasi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke laporan terkait (opsional).
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    /**
     * Scope: notifikasi yang belum dibaca.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: notifikasi milik pengguna tertentu.
     */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}
