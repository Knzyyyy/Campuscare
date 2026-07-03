@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800">Kelola Kategori</h2>
        <a href="{{ route('superadmin.kategori.create') }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700 transition">+ Tambah Kategori</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Urutan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Ikon</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Estimasi</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Scope</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($kategoris as $k)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 text-center text-slate-500">{{ $k->urutan }}</td>
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $k->nama }}</td>
                        <td class="px-4 py-3 text-slate-500 font-mono text-xs">{{ $k->ikon }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $k->estimasi_hari }} hari</td>
                        <td class="px-4 py-3">
                            @if($k->fakultas_id)
                                <span class="px-2 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700">Per Fakultas</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-600">Global</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($k->is_active)
                                <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('superadmin.kategori.edit', $k) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                                <form action="{{ route('superadmin.kategori.destroy', $k) }}" method="POST"
                                    onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-12 text-slate-400">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $kategoris->links() }}</div>
    </div>
</div>
@endsection