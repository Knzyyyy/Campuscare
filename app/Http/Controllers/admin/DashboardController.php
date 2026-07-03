<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Laporan::query();
        if ($user->role === 'admin_prodi') {
            $query->whereHas('user', fn($q) => $q->where('prodi_id', $user->prodi_id));
        } elseif ($user->role === 'admin_fakultas') {
            $query->whereHas('user', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }

        $stats = [
            'total'    => (clone $query)->count(),
            'terkirim' => (clone $query)->where('status', 'terkirim')->count(),
            'diproses' => (clone $query)->where('status', 'diproses')->count(),
            'selesai'  => (clone $query)->where('status', 'selesai')->count(),
            'ditolak'  => (clone $query)->where('status', 'ditolak')->count(),
        ];

        $laporanMenunggu = (clone $query)
            ->where('status', 'terkirim')
            ->with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        $laporanTerbaru = (clone $query)
            ->with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        $kategoriBreakdown = (clone $query)
            ->with('kategori')
            ->get()
            ->groupBy(fn($l) => $l->kategori->nama ?? 'Lainnya')
            ->map(fn($g, $nama) => ['nama' => $nama, 'count' => $g->count()])
            ->sortByDesc('count')
            ->values();

        $grafikBulanan = collect(range(5, 0))->map(function ($i) use ($query) {
            $bulan = now()->subMonths($i);
            return [
                'bulan' => $bulan->translatedFormat('M'),
                'total' => (clone $query)
                    ->whereYear('created_at', $bulan->year)
                    ->whereMonth('created_at', $bulan->month)
                    ->count(),
            ];
        });

        return view('admin.dashboard', compact(
            'stats', 'laporanMenunggu', 'laporanTerbaru', 'kategoriBreakdown', 'grafikBulanan'
        ));
    }
}