<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturans = Pengaturan::all()->keyBy('kunci');
        return view('superadmin.pengaturan.index', compact('pengaturans'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi'    => 'required|string',
            'tagline'          => 'required|string',
            'email_admin'      => 'required|email',
            'sla_default_hari' => 'required|integer|min:1',
            'max_upload_mb'    => 'required|integer|min:1',
            'max_foto_laporan' => 'required|integer|min:1',
        ]);

        foreach ($request->except('_token') as $kunci => $nilai) {
            Pengaturan::set($kunci, $nilai);
        }

        return redirect()->route('superadmin.pengaturan.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}