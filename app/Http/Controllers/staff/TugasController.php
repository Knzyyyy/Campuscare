<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LaporanLampiran;
use App\Models\LaporanStatusLog;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::where('assigned_staff_id', Auth::id())
            ->with('kategori')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $laporans = $query->paginate(10)->withQueryString();
        $kategoris = \App\Models\Kategori::active()->get();

        return view('staff.tugas.index', compact('laporans', 'kategoris'));
    }

    public function show(Laporan $laporan)
    {
        abort_if($laporan->assigned_staff_id !== Auth::id(), 403);
        $laporan->load(['user', 'kategori', 'lampirans', 'statusLogs.user']);
        return view('staff.tugas.show', compact('laporan'));
    }

    public function selesai(Request $request, Laporan $laporan)
    {
        abort_if($laporan->assigned_staff_id !== Auth::id(), 403);

        $request->validate([
            'keterangan' => 'required|string',
            'bukti'      => 'nullable|array|max:3',
            'bukti.*'    => 'image|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $path = $file->store("bukti/{$laporan->id}", 'public');
                LaporanLampiran::create([
                    'laporan_id' => $laporan->id,
                    'nama_file'  => $file->getClientOriginalName(),
                    'path'       => $path,
                    'tipe'       => 'bukti_penyelesaian',
                    'uploaded_by'=> Auth::id(),
                ]);
            }
        }

        $laporan->update([
            'status'       => 'selesai',
            'processed_by' => Auth::id(),
            'completed_at' => now(),
        ]);

        LaporanStatusLog::create([
            'laporan_id'  => $laporan->id,
            'user_id'     => Auth::id(),
            'status_lama' => 'diproses',
            'status_baru' => 'selesai',
            'keterangan'  => $request->keterangan,
        ]);

        Notifikasi::create([
            'user_id'    => $laporan->user_id,
            'laporan_id' => $laporan->id,
            'tipe'       => 'status_update',
            'judul'      => 'Laporan Selesai',
            'pesan'      => "Laporan {$laporan->nomor_laporan} telah diselesaikan.",
        ]);

        return redirect()->route('staff.tugas.index')
            ->with('success', 'Laporan berhasil ditandai selesai.');
    }
}