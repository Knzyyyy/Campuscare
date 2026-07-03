@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800">Kelola User</h2>
        <a href="{{ route('superadmin.users.create') }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700 transition">+ Tambah User</a>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <form method="GET" class="flex flex-col md:flex-row gap-3">
            <select name="role" class="border border-slate-200 rounded-lg px-3 py-2 text-sm" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                @foreach(['mahasiswa','dosen','admin_prodi','admin_fakultas','staff','super_admin'] as $r)
                <option value="{{ $r }}" {{ request('role')===$r?'selected':'' }}>{{ ucwords(str_replace('_',' ',$r)) }}</option>
                @endforeach
            </select>
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="w-full border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="bg-slate-100 text-slate-700 text-sm px-4 py-2 rounded-lg hover:bg-slate-200 transition">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Email</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Role</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Fakultas</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <span class="font-medium text-slate-700">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $u->email }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 capitalize">{{ str_replace('_',' ',$u->role) }}</span></td>
                        <td class="px-4 py-3 text-slate-500">{{ $u->fakultas->nama ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($u->is_active)
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('superadmin.users.edit', $u) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                                <form action="{{ route('superadmin.users.toggleAktif', $u) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs {{ $u->is_active ? 'text-red-500 hover:underline' : 'text-green-600 hover:underline' }}">
                                        {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-12 text-slate-400">Tidak ada user.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $users->links() }}</div>
    </div>
</div>
@endsection