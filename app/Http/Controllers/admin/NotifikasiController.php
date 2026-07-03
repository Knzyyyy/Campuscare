<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Auth::user()->notifikasis()->latest()->paginate(15);
        return view('admin.notifikasi.index', compact('notifikasis'));
    }

    public function markRead($id)
    {
        $notifikasi = Auth::user()->notifikasis()->findOrFail($id);
        $notifikasi->markAsRead();

        if (request()->isMethod('post')) {
            return redirect()->back()->with('success', 'Notifikasi ditandai dibaca.');
        }

        if ($notifikasi->url) {
            return redirect($notifikasi->url);
        }

        if ($notifikasi->laporan_id) {
            return redirect()->route('admin.laporan.show', $notifikasi->laporan_id);
        }

        return redirect()->route('admin.notifikasi.index');
    }

    public function markAllRead()
    {
        Auth::user()->notifikasis()->where('is_read', false)->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }
}