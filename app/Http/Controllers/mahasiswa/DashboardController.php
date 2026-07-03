<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalLaporan = $user->laporans()->count();
        $diproses     = $user->laporans()->where('status', 'diproses')->count();
        $selesai      = $user->laporans()->where('status', 'selesai')->count();
        $ditolak      = $user->laporans()->where('status', 'ditolak')->count();

        $laporanTerbaru = $user->laporans()
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $dataGrafik = $user->laporans()
            ->with('kategori')
            ->get()
            ->groupBy('kategori.nama')
            ->map(fn($g) => $g->count());

        return view('mahasiswa.dashboard', compact(
            'totalLaporan', 'diproses', 'selesai', 'ditolak',
            'laporanTerbaru', 'dataGrafik'
        ));
    }
}