<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'total'         => Laporan::where('assigned_staff_id', $userId)->count(),
            'diproses'      => Laporan::where('assigned_staff_id', $userId)->where('status', 'diproses')->count(),
            'selesai_hari'  => Laporan::where('assigned_staff_id', $userId)->where('status', 'selesai')->whereDate('completed_at', today())->count(),
            'selesai_bulan' => Laporan::where('assigned_staff_id', $userId)->where('status', 'selesai')->whereMonth('completed_at', now()->month)->count(),
        ];

        $ratingQuery = Laporan::where('assigned_staff_id', $userId)->whereNotNull('rating');
        $stats['avg_rating'] = round($ratingQuery->avg('rating'), 1) ?: 0;
        $stats['total_rating'] = $ratingQuery->count();

        $tugasBaru = Laporan::where('assigned_staff_id', $userId)
            ->where('status', 'diproses')
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $umpanBalik = Laporan::where('assigned_staff_id', $userId)
            ->whereNotNull('rating')
            ->with('user')
            ->latest('completed_at')
            ->take(3)
            ->get();

        return view('staff.dashboard', compact('stats', 'tugasBaru', 'umpanBalik'));
    }
}