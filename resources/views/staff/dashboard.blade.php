@extends('layouts.app')
@section('title', 'Dashboard Staff')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="text-xl font-bold text-slate-800">Dashboard Staff</h2>
        <p class="text-sm text-slate-500 mt-0.5">Kelola dan selesaikan tugas yang ditugaskan</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #3b82f6, #2563EB);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Total Ditugaskan</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #fbbf24, #f59e0b);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['diproses'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Sedang Dikerjakan</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #34d399, #10b981);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['selesai_hari'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Selesai Hari Ini</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #2dd4bf, #0d9488);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['selesai_bulan'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Selesai Bulan Ini</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm col-span-2 lg:col-span-1">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <svg class="w-5 h-5 text-white fill-white" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['avg_rating'] }} <span class="text-sm font-normal text-slate-400">/ 5</span></p>
            <p class="text-xs text-slate-500 mt-0.5">Rating Kinerja ({{ $stats['total_rating'] }} Penilaian)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Tugas Aktif --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-slate-800">Tugas Aktif</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $tugasBaru->count() }} tugas perlu diselesaikan</p>
                    </div>
                    <a href="{{ route('staff.tugas.index') }}" class="flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-700 whitespace-nowrap">
                        Semua Tugas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($tugasBaru as $t)
                    @php
                        $pc=['rendah'=>'text-green-600 bg-green-50 border-green-100','sedang'=>'text-amber-600 bg-amber-50 border-amber-100','tinggi'=>'text-red-600 bg-red-50 border-red-100'];
                        $sc=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700'];
                    @endphp
                    <div class="p-5 hover:bg-slate-50 transition-colors">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-sm font-semibold text-slate-800">{{ $t->judul }}</p>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full border capitalize {{ $pc[$t->prioritas] ?? '' }}">{{ $t->prioritas }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $sc[$t->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($t->status) }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $t->lokasi }}
                                    </span>
                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Update: {{ $t->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1.5 line-clamp-1">{{ $t->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 mt-3 ml-14">
                            <a href="{{ route('staff.tugas.show', $t) }}" class="flex-1 text-center py-2 px-3 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition-colors">
                                Lihat Detail
                            </a>
                            <a href="{{ route('staff.tugas.show', $t) }}" class="py-2 px-3 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition-colors border border-slate-200 whitespace-nowrap">
                                Upload Bukti
                            </a>
                            <a href="{{ route('staff.tugas.show', $t) }}" class="py-2 px-3 bg-green-100 text-green-700 rounded-xl text-xs font-semibold hover:bg-green-200 transition-colors whitespace-nowrap">
                                Selesai
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-12 text-center text-slate-400 text-sm">Tidak ada tugas baru. 🎉</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="space-y-4">

            {{-- Progress Hari Ini --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-4">Progress Hari Ini</h3>
                @php
                    $totalHariIni = $stats['selesai_hari'] + $tugasBaru->count();
                    $pct = $totalHariIni > 0 ? round(($stats['selesai_hari'] / $totalHariIni) * 100) : 0;
                    $circumference = 2 * pi() * 15.9;
                    $dash = $circumference * ($pct / 100);
                    $gap = $circumference - $dash;
                @endphp
                <div class="text-center mb-4">
                    <div class="relative w-24 h-24 mx-auto">
                        <svg viewBox="0 0 36 36" class="w-24 h-24 -rotate-90">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#E2E8F0" stroke-width="2.5"/>
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#2563EB" stroke-width="2.5"
                                    stroke-dasharray="{{ $dash }} {{ $gap }}" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <p class="text-2xl font-bold text-slate-800">{{ $pct }}%</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 mt-2">{{ $stats['selesai_hari'] }} dari {{ $totalHariIni }} tugas selesai</p>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                            <span class="text-xs text-slate-600">Selesai</span>
                        </div>
                        <span class="text-xs font-bold text-slate-800">{{ $stats['selesai_hari'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                            <span class="text-xs text-slate-600">Dikerjakan</span>
                        </div>
                        <span class="text-xs font-bold text-slate-800">{{ $tugasBaru->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Umpan Balik Pelapor --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-3 text-sm">Umpan Balik Pelapor</h3>
                <div class="space-y-4">
                    @forelse($umpanBalik as $ub)
                    <div class="border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-semibold text-slate-700 truncate">{{ $ub->user->name ?? 'Pelapor' }}</span>
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 {{ $i <= $ub->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200 fill-slate-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 mt-0.5">
                            <span>{{ $ub->nomor_laporan }}</span>
                            <span>{{ $ub->completed_at ? \Carbon\Carbon::parse($ub->completed_at)->format('d M Y') : '' }}</span>
                        </div>
                        @if($ub->feedback)
                        <p class="text-xs text-slate-600 mt-1.5 italic bg-slate-50 p-2 rounded-lg border border-slate-100">"{{ $ub->feedback }}"</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic text-center py-2">Belum ada umpan balik.</p>
                    @endforelse
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-3">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('staff.tugas.index') }}"
                       class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-medium transition-colors border border-slate-100">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Lihat Semua Tugas
                    </a>
                    <a href="{{ route('staff.tugas.index', ['status' => 'selesai']) }}"
                       class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-medium transition-colors border border-slate-100">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Riwayat Tugas Selesai
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection