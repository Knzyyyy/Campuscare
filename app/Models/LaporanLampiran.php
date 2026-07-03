<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LaporanLampiran extends Model
{
    use HasFactory;

    public const TIPE_LAMPIRAN_AWAL = 'lampiran_awal';

    public const TIPE_BUKTI_PENYELESAIAN = 'bukti_penyelesaian';

    public const TIPE_DOKUMEN_TAMBAHAN = 'dokumen_tambahan';

    protected $table = 'laporan_lampirans';

    protected $fillable = [
        'laporan_id',
        'uploaded_by',
        'tipe',
        'nama_file',
        'path',
        'mime_type',
        'ukuran',
        'keterangan',
    ];

    protected $casts = [
        'tipe' => 'string',
        'ukuran' => 'integer',
    ];

    /**
     * Relasi ke laporan pemilik lampiran.
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    /**
     * Relasi ke pengguna yang mengunggah file.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Accessor: URL publik file lampiran.
     */
    protected function fileUrl(): Attribute
    {
        return Attribute::get(fn () => Storage::url($this->path));
    }
}
