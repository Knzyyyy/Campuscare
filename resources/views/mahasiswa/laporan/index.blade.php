@extends('layouts.app')
@section('title', 'Riwayat Laporan')

@section('content')
<div class="space-y-5 pb-24 lg:pb-0">

    {{-- HEADER Desktop --}}
    <div class="hidden lg:flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Riwayat Laporan</h2>
            <p class="text-sm text-slate-500 mt-0.5">{{ $laporans->total() }} laporan ditemukan</p>
        </div>
        <a href="{{ route('mahasiswa.laporan.create') }}"
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-semibold text-sm transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan
        </a>
    </div>

    {{-- HEADER Mobile --}}
    <div class="lg:hidden">
        <h2 class="text-xl font-bold text-slate-800">Riwayat Laporan</h2>
        <p class="text-sm text-slate-500 mt-0.5">{{ $laporans->total() }} laporan ditemukan</p>
    </div>

    {{-- FILTER Desktop --}}
    <div class="hidden lg:block bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..."
                    class="w-full h-10 pl-9 pr-4 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all">
            </div>
            @if(request('search'))
            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm px-4 rounded-xl transition">Cari</button>
            @endif
        </form>
        <div class="flex gap-2 mt-3 flex-wrap">
            @foreach([''=> 'Semua','terkirim'=>'Terkirim','diverifikasi'=>'Diverifikasi','diproses'=>'Diproses','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $val=>$label)
            <a href="{{ request()->fullUrlWithQuery(['status'=>$val]) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status')===$val ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- FILTER Mobile: horizontal scroll pills --}}
    <div class="lg:hidden -mx-4 px-4">
        <div class="flex gap-2 overflow-x-auto pb-1 flex-nowrap scrollbar-none">
            @foreach([''=> 'Semua','terkirim'=>'Terkirim','diverifikasi'=>'Diverifikasi','diproses'=>'Diproses','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $val=>$label)
            <a href="{{ request()->fullUrlWithQuery(['status'=>$val]) }}"
               class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold transition-all {{ request('status')===$val ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- TABEL Desktop --}}
    <div class="hidden md:block bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">No. Laporan</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Judul</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Kategori</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Tanggal</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Status</th>
                        <th class="text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporans as $l)
                    @php $colors=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700']; @endphp
                    <tr class="hover:bg-blue-50/40 transition-colors group">
                        <td class="px-5 py-4">
                            <span class="text-xs font-mono text-slate-500">{{ $l->nomor_laporan }}</span>
                        </td>
                        <td class="px-5 py-4 max-w-56">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $l->judul }}</p>
                            <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $l->lokasi ?? '-' }}
                            </p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-xs font-medium text-slate-600 rounded-full">
                                {{ $l->kategori->nama ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm text-slate-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $l->created_at->format('d M Y') }}
                            </p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$l->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($l->status) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('mahasiswa.laporan.show', $l) }}" title="Lihat Detail"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 flex items-center justify-center text-slate-500 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if($l->status === 'terkirim')
                                <form action="{{ route('mahasiswa.laporan.destroy', $l) }}" method="POST"
                                    onsubmit="return confirm('Hapus laporan {{ $l->nomor_laporan }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-100 hover:text-red-700 flex items-center justify-center text-slate-500 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16">
                            <div class="text-center">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <h3 class="text-base font-semibold text-slate-600 mb-1">Tidak ada laporan</h3>
                                <p class="text-sm text-slate-400">Coba ubah kata kunci atau filter yang digunakan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporans->count())
        <div class="px-5 py-3 border-t border-slate-100">{{ $laporans->links() }}</div>
        @endif
    </div>

    {{-- CARDS Mobile --}}
    <div class="md:hidden space-y-3">
        @forelse($laporans as $l)
        @php $colors=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700']; @endphp
        <a href="{{ route('mahasiswa.laporan.show', $l) }}"
           class="relative block bg-white rounded-2xl border border-slate-100 shadow-sm p-4 hover:border-blue-200 transition-all min-h-[80px]">
            {{-- Status badge pojok kanan atas --}}
            <span class="absolute top-4 right-4 px-2.5 py-1 rounded-full text-xs font-semibold {{ $colors[$l->status] ?? 'bg-slate-100 text-slate-600' }} whitespace-nowrap">{{ ucfirst($l->status) }}</span>

            <div class="flex items-start gap-3 pr-20">
                <div>
                    <p class="font-semibold text-slate-800 leading-tight text-base">{{ $l->judul }}</p>
                    <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $l->nomor_laporan }}</p>
                    <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $l->lokasi ?? '-' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $l->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="px-2.5 py-0.5 bg-slate-100 text-xs font-medium text-slate-600 rounded-full">{{ $l->kategori->nama ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <svg class="absolute right-4 bottom-4 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        @empty
        <div class="bg-white rounded-2xl p-10 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <p class="font-semibold text-slate-600 mb-1">Tidak ada laporan</p>
            <p class="text-sm text-slate-400">Coba ubah filter yang digunakan</p>
        </div>
        @endforelse
        @if($laporans->count())
        <div class="pt-2">{{ $laporans->links() }}</div>
        @endif
    </div>
</div>
@endsection