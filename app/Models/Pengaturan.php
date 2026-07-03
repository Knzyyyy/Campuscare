<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturans';

    protected $fillable = [
        'kunci',
        'nilai',
        'tipe',
        'grup',
        'label',
        'deskripsi',
    ];

    /**
     * Ambil nilai pengaturan berdasarkan kunci.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $pengaturan = static::where('kunci', $key)->first();

        if (! $pengaturan) {
            return $default;
        }

        return static::castNilai($pengaturan->nilai, $pengaturan->tipe);
    }

    /**
     * Simpan atau perbarui nilai pengaturan berdasarkan kunci.
     */
    public static function set(string $key, mixed $value, string $tipe = 'string'): Pengaturan
    {
        $nilai = is_array($value) ? json_encode($value) : (string) $value;

        return static::updateOrCreate(
            ['kunci' => $key],
            ['nilai' => $nilai, 'tipe' => $tipe]
        );
    }

    /**
     * Cast nilai string dari database ke tipe data yang sesuai.
     */
    protected static function castNilai(?string $nilai, string $tipe): mixed
    {
        if ($nilai === null) {
            return null;
        }

        return match ($tipe) {
            'boolean' => filter_var($nilai, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $nilai,
            'json' => json_decode($nilai, true),
            default => $nilai,
        };
    }
}
