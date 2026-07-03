<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $statsUser = [
            'mahasiswa'      => User::where('role', 'mahasiswa')->count(),
            'dosen'          => User::where('role', 'dosen')->count(),
            'admin'          => User::whereIn('role', ['admin_prodi', 'admin_fakultas'])->count(),
            'staff'          => User::where('role', 'staff')->count(),
            'super_admin'    => User::where('role', 'super_admin')->count(),
        ];

        $statsLaporan = [
            'total'      => Laporan::count(),
            'terkirim'   => Laporan::where('status', 'terkirim')->count(),
            'diverifikasi' => Laporan::where('status', 'diverifikasi')->count(),
            'diproses'   => Laporan::where('status', 'diproses')->count(),
            'selesai'    => Laporan::where('status', 'selesai')->count(),
            'ditolak'    => Laporan::where('status', 'ditolak')->count(),
        ];

        $grafikBulanan = collect(range(5, 0))->map(fn($i) => [
            'bulan' => now()->subMonths($i)->format('M'),
            'total' => Laporan::whereYear('created_at', now()->subMonths($i)->year)
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->count(),
        ]);

        $userTerbaru = User::latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'statsUser', 'statsLaporan', 'grafikBulanan', 'userTerbaru'
        ));
    }
}