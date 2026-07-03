@extends('layouts.app')
@section('title', 'Kelola Laporan')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div>
        <h2 class="text-xl font-bold text-slate-800">Manajemen Laporan</h2>
        <p class="text-sm text-slate-500 mt-0.5">{{ $laporans->total() }} laporan ditemukan</p>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan atau pelapor..."
                    class="w-full h-10 pl-9 pr-4 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all">
            </div>
            <div class="flex items-center gap-1 text-slate-500 sm:hidden">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span class="text-sm font-medium">Filter</span>
            </div>
            @if(request('search'))
            <button type="submit" class="hidden sm:block bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm px-4 rounded-xl transition">Cari</button>
            @endif
        </form>

        {{-- Filter Pills --}}
        <div class="flex gap-2 mt-3 flex-wrap">
            @foreach(['' => 'Semua', 'terkirim' => 'Terkirim', 'diverifikasi' => 'Diverifikasi', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === $val ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Tabel Desktop --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hidden md:block">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5">Laporan</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5">Pelapor</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5 hidden lg:table-cell">Kategori</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5 hidden sm:table-cell">Tanggal</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5">Prioritas</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5">Status</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-4 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporans as $l)
                    @php
                        $sc=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700'];
                        $pc=['rendah'=>'bg-green-100 text-green-700','sedang'=>'bg-yellow-100 text-yellow-700','tinggi'=>'bg-red-100 text-red-700'];
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3.5 max-w-48">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $l->judul }}</p>
                            <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $l->lokasi ?? '-' }}
                            </p>
                            <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $l->nomor_laporan }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            <p class="text-sm text-slate-600 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                {{ $l->user->name }}
                            </p>
                        </td>
                        <td class="px-4 py-3.5 hidden lg:table-cell">
                            <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-xs font-medium text-slate-600 rounded-full">
                                {{ $l->kategori->nama ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 hidden sm:table-cell">
                            <p class="text-sm text-slate-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $l->created_at->format('d M Y') }}
                            </p>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $pc[$l->prioritas] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($l->prioritas) }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc[$l->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($l->status) }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.laporan.show', $l) }}" title="Lihat Detail"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 flex items-center justify-center text-slate-500 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if($l->status === 'terkirim')
                                <a href="{{ route('admin.laporan.show', $l) }}" title="Verifikasi"
                                   class="w-8 h-8 rounded-lg bg-green-100 hover:bg-green-200 flex items-center justify-center text-green-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </a>
                                @endif
                                @if($l->status === 'diverifikasi')
                                <a href="{{ route('admin.laporan.show', $l) }}" title="Assign Staff"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-indigo-100 flex items-center justify-center text-slate-500 hover:text-indigo-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16">
                            <div class="text-center">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <h3 class="text-base font-semibold text-slate-600 mb-1">Tidak ada laporan ditemukan</h3>
                                <p class="text-sm text-slate-400">Coba ubah kata kunci atau filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporans->count())
        <div class="px-4 py-3 border-t border-slate-100">{{ $laporans->links() }}</div>
        @endif
    </div>

    {{-- Card List Mobile --}}
    <div class="md:hidden space-y-3">
        @forelse($laporans as $l)
        @php
            $sc=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700'];
            $pc=['rendah'=>'bg-green-100 text-green-700','sedang'=>'bg-yellow-100 text-yellow-700','tinggi'=>'bg-red-100 text-red-700'];
        @endphp
        <a href="{{ route('admin.laporan.show', $l) }}" class="block bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="flex items-start justify-between gap-2 mb-2">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $l->judul }}</p>
                    <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $l->nomor_laporan }}</p>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc[$l->status] ?? 'bg-slate-100 text-slate-600' }} whitespace-nowrap">{{ ucfirst($l->status) }}</span>
            </div>
            <div class="flex items-center gap-3 text-xs text-slate-400">
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $l->lokasi ?? '-' }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    {{ $l->user->name }}
                </span>
            </div>
            <div class="flex items-center justify-between mt-2">
                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $pc[$l->prioritas] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($l->prioritas) }}</span>
                <span class="text-xs text-slate-400">{{ $l->created_at->format('d M Y') }}</span>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-2xl p-10 text-center text-slate-400 text-sm">Tidak ada laporan.</div>
        @endforelse
        @if($laporans->count())
        <div>{{ $laporans->links() }}</div>
        @endif
    </div>
</div>
@endsection