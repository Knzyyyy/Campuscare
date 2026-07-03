<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LaporanStatusLog;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    private function scopedQuery()
    {
        $user  = Auth::user();
        $query = Laporan::with(['user', 'kategori', 'assignedStaff']);

        if ($user->role === 'admin_prodi') {
            $query->whereHas('user', fn($q) => $q->where('prodi_id', $user->prodi_id));
        } elseif ($user->role === 'admin_fakultas') {
            $query->whereHas('user', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->scopedQuery()->latest();

        if ($request->status)   $query->where('status', $request->status);
        if ($request->search)   $query->where(fn($q) => $q->where('judul', 'like', "%{$request->search}%")->orWhere('nomor_laporan', 'like', "%{$request->search}%"));

        $laporans = $query->paginate(15)->withQueryString();
        return view('admin.laporan.index', compact('laporans'));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load(['user', 'kategori', 'lampirans', 'statusLogs.user', 'assignedStaff']);
        $staffList = User::where('role', 'staff')->get();
        return view('admin.laporan.show', compact('laporan', 'staffList'));
    }

    public function verifikasi(Request $request, Laporan $laporan)
    {
        $request->validate(['keterangan' => 'required|string']);

        $laporan->update([
            'status'      => 'diverifikasi',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        LaporanStatusLog::create([
            'laporan_id'  => $laporan->id,
            'user_id'     => Auth::id(),
            'status_lama' => 'terkirim',
            'status_baru' => 'diverifikasi',
            'keterangan'  => $request->keterangan,
        ]);

        Notifikasi::create([
            'user_id'    => $laporan->user_id,
            'laporan_id' => $laporan->id,
            'tipe'       => 'status_update',
            'judul'      => 'Laporan Diverifikasi',
            'pesan'      => "Laporan {$laporan->nomor_laporan} telah diverifikasi.",
        ]);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function tolak(Request $request, Laporan $laporan)
    {
        $request->validate(['keterangan' => 'required|string']);

        $laporan->update([
            'status'      => 'ditolak',
            'rejected_at' => now(),
        ]);

        LaporanStatusLog::create([
            'laporan_id'  => $laporan->id,
            'user_id'     => Auth::id(),
            'status_lama' => 'terkirim',
            'status_baru' => 'ditolak',
            'keterangan'  => $request->keterangan,
        ]);

        Notifikasi::create([
            'user_id'    => $laporan->user_id,
            'laporan_id' => $laporan->id,
            'tipe'       => 'status_update',
            'judul'      => 'Laporan Ditolak',
            'pesan'      => "Laporan {$laporan->nomor_laporan} ditolak. Alasan: {$request->keterangan}",
        ]);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Laporan ditolak.');
    }

    public function assign(Request $request, Laporan $laporan)
    {
        $request->validate(['staff_id' => 'required|exists:users,id']);

        $laporan->update([
            'assigned_staff_id' => $request->staff_id,
            'status'            => 'diproses',
            'assigned_at'       => now(),
        ]);

        LaporanStatusLog::create([
            'laporan_id'  => $laporan->id,
            'user_id'     => Auth::id(),
            'status_lama' => 'diverifikasi',
            'status_baru' => 'diproses',
            'keterangan'  => 'Ditugaskan ke staff: ' . User::find($request->staff_id)->name,
        ]);

        Notifikasi::create([
            'user_id'    => $request->staff_id,
            'laporan_id' => $laporan->id,
            'tipe'       => 'assignment',
            'judul'      => 'Tugas Baru',
            'pesan'      => "Anda ditugaskan menangani laporan {$laporan->nomor_laporan}.",
            'url'        => route('staff.tugas.show', $laporan->id),
        ]);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Staff berhasil ditugaskan.');
    }
}