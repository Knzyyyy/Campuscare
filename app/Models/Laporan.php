<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_TERKIRIM = 'terkirim';

    public const STATUS_DIVERIFIKASI = 'diverifikasi';

    public const STATUS_DIPROSES = 'diproses';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_DITOLAK = 'ditolak';

    public const PRIORITAS_RENDAH = 'rendah';

    public const PRIORITAS_SEDANG = 'sedang';

    public const PRIORITAS_TINGGI = 'tinggi';

    protected $fillable = [
        'nomor_laporan',
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lokasi',
        'prioritas',
        'status',
        'fakultas_id',
        'prodi_id',
        'assigned_staff_id',
        'verified_by',
        'processed_by',
        'submitted_at',
        'verified_at',
        'assigned_at',
        'processed_at',
        'completed_at',
        'rejected_at',
        'catatan_admin',
        'alasan_penolakan',
        'catatan_staff',
        'rating',
        'feedback',
    ];

    protected $casts = [
        'prioritas' => 'string',
        'status' => 'string',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'assigned_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'rejected_at' => 'datetime',
        'rating' => 'integer',
    ];

    /**
     * Relasi ke pelapor (mahasiswa / dosen).
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias relasi pelapor untuk kompatibilitas pemanggilan user().
     */
    public function user(): BelongsTo
    {
        return $this->pelapor();
    }

    /**
     * Relasi ke kategori layanan laporan.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke fakultas scope laporan.
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Relasi ke prodi scope laporan.
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    /**
     * Relasi ke staff yang ditugaskan menangani laporan.
     */
    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    /**
     * Relasi ke admin yang memverifikasi laporan.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Relasi ke staff yang memproses laporan.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Relasi ke riwayat perubahan status laporan.
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(LaporanStatusLog::class);
    }

    /**
     * Relasi ke lampiran dan bukti laporan.
     */
    public function lampirans(): HasMany
    {
        return $this->hasMany(LaporanLampiran::class);
    }

    /**
     * Relasi ke notifikasi yang terkait laporan ini.
     */
    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Scope: filter berdasarkan status laporan.
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: filter berdasarkan prioritas laporan.
     */
    public function scopeByPrioritas(Builder $query, string $prioritas): Builder
    {
        return $query->where('prioritas', $prioritas);
    }

    /**
     * Scope: laporan milik pengguna tertentu (sebagai pelapor).
     */
    public function scopeMilikUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Accessor: warna badge status sesuai design system CampusCare.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_TERKIRIM => '#3B82F6',
            self::STATUS_DIVERIFIKASI => '#6366F1',
            self::STATUS_DIPROSES => '#F59E0B',
            self::STATUS_SELESAI => '#10B981',
            self::STATUS_DITOLAK => '#EF4444',
            default => '#6B7280',
        };
    }

    /**
     * Accessor: nomor tiket terformat untuk tampilan UI.
     */
    public function getNomorTiketFormattedAttribute(): string
    {
        return $this->nomor_laporan;
    }

    /**
     * Generate nomor tiket unik format CC-YYYY-NNNNN.
     */
    public static function generateNomorTiket(): string
    {
        $tahun = now()->year;
        $prefix = "CC-{$tahun}-";

        $terakhir = static::withTrashed()
            ->where('nomor_laporan', 'like', "{$prefix}%")
            ->orderByDesc('nomor_laporan')
            ->value('nomor_laporan');

        $urutan = $terakhir
            ? (int) substr($terakhir, -5) + 1
            : 1;

        return $prefix.str_pad((string) $urutan, 5, '0', STR_PAD_LEFT);
    }
}
