<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Auth::user()->notifikasis()->latest()->paginate(15);
        return view('staff.notifikasi.index', compact('notifikasis'));
    }

    public function markRead($id)
    {
        $notifikasi = Auth::user()->notifikasis()->findOrFail($id);
        $notifikasi->markAsRead();

        if (request()->isMethod('post')) {
            return redirect()->back()->with('success', 'Notifikasi ditandai dibaca.');
        }

        // Redirect ke URL tersimpan jika ada
        if ($notifikasi->url) {
            return redirect($notifikasi->url);
        }

        // Fallback: ke detail tugas jika notifikasi punya laporan
        if ($notifikasi->laporan_id) {
            return redirect()->route('staff.tugas.show', $notifikasi->laporan_id);
        }

        return redirect()->route('staff.notifikasi.index');
    }

    public function markAllRead()
    {
        Auth::user()->notifikasis()->where('is_read', false)->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }
}