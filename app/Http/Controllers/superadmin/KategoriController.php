<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('urutan')->paginate(20);
        return view('superadmin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('superadmin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'ikon'          => 'required|string|max:50',
            'estimasi_hari' => 'required|integer|min:1',
            'urutan'        => 'required|integer|min:1',
        ]);

        Kategori::create($request->only('nama', 'ikon', 'estimasi_hari', 'urutan', 'is_active'));
        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('superadmin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'ikon'          => 'required|string|max:50',
            'estimasi_hari' => 'required|integer|min:1',
            'urutan'        => 'required|integer|min:1',
        ]);

        $kategori->update($request->only('nama', 'ikon', 'estimasi_hari', 'urutan', 'is_active'));
        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}