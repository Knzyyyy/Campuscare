<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanStatusLog extends Model
{
    use HasFactory;

    protected $table = 'laporan_status_logs';

    protected $fillable = [
        'laporan_id',
        'user_id',
        'status_lama',
        'status_baru',
        'keterangan',
        'ip_address',
    ];

    protected $casts = [
        'status_lama' => 'string',
        'status_baru' => 'string',
    ];

    /**
     * Relasi ke laporan yang statusnya berubah.
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    /**
     * Relasi ke pengguna yang melakukan perubahan status.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
