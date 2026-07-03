<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Laporan;
use App\Models\LaporanLampiran;
use App\Models\LaporanStatusLog;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->laporans()->with('kategori')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->paginate(10)->withQueryString();

        return view('mahasiswa.laporan.index', compact('laporans'));
    }

    public function create()
    {
        $kategoris = Kategori::active()->get();
        return view('mahasiswa.laporan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul'       => 'required|string|max:255',
            'lokasi'      => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'prioritas'   => 'required|in:rendah,sedang,tinggi',
            'foto'        => 'nullable|array|max:3',
            'foto.*'      => 'image|max:2048',
        ]);

        $laporan = Laporan::create([
            'nomor_laporan' => Laporan::generateNomorTiket(),
            'user_id'       => Auth::id(),
            'kategori_id'   => $request->kategori_id,
            'judul'         => $request->judul,
            'lokasi'        => $request->lokasi,
            'deskripsi'     => $request->deskripsi,
            'prioritas'     => $request->prioritas,
            'status'        => 'terkirim',
            'submitted_at'  => now(),
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store("laporan/{$laporan->id}", 'public');
                LaporanLampiran::create([
                    'laporan_id'  => $laporan->id,
                    'uploaded_by' => Auth::id(),
                    'tipe'        => 'lampiran_awal',
                    'nama_file'   => $file->getClientOriginalName(),
                    'path'        => $path,
                    'mime_type'   => $file->getClientMimeType(),
                    'ukuran'      => $file->getSize(),
                ]);
            }
        }

        // Status log pertama
        LaporanStatusLog::create([
            'laporan_id'  => $laporan->id,
            'user_id'     => Auth::id(),
            'status_lama' => null,
            'status_baru' => 'terkirim',
            'keterangan'  => 'Laporan dibuat oleh pelapor.',
        ]);

        // Kirim notifikasi ke semua admin
        $admins = User::whereIn('role', ['admin_prodi', 'admin_fakultas', 'super_admin'])->get();
        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id'    => $admin->id,
                'laporan_id' => $laporan->id,
                'tipe'       => 'laporan_baru',
                'judul'      => 'Laporan Baru Masuk',
                'pesan'      => "Laporan baru #{$laporan->nomor_laporan} dari {$laporan->pelapor->name} menunggu verifikasi.",
                'url'        => route('admin.laporan.show', $laporan->id),
            ]);
        }

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan berhasil dikirim! Nomor: ' . $laporan->nomor_laporan);
    }

    public function show(Laporan $laporan)
    {
        abort_if($laporan->user_id !== Auth::id(), 403);

        $laporan->load(['kategori', 'lampirans', 'statusLogs.user']);

        return view('mahasiswa.laporan.show', compact('laporan'));
    }

    public function destroy(Laporan $laporan)
    {
        abort_if($laporan->user_id !== Auth::id(), 403);
        abort_if($laporan->status !== 'terkirim', 403, 'Laporan yang sudah diproses tidak dapat dihapus.');

        // Hapus file lampiran dari storage
        foreach ($laporan->lampirans as $lampiran) {
            Storage::disk('public')->delete($lampiran->path);
        }

        $laporan->delete();

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function submitRating(Request $request, Laporan $laporan)
    {
        abort_if($laporan->user_id !== Auth::id(), 403);

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);

        $laporan->update([
            'rating'   => $request->rating,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('mahasiswa.laporan.show', $laporan)
            ->with('success', 'Terima kasih atas penilaian Anda!');
    }
}