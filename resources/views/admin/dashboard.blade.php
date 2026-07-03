@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">

    {{-- Welcome --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Dashboard Admin</h2>
            <p class="text-sm text-slate-500 mt-0.5">Monitor dan kelola semua laporan masuk</p>
        </div>
        <a href="{{ route('admin.laporan.index') }}"
           class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-semibold text-sm transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-200 w-fit">
            Kelola Laporan
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #3b82f6, #2563EB);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Total Laporan</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #fb7185, #ef4444);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['terkirim'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Menunggu Verifikasi</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #fbbf24, #f59e0b);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['diproses'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Sedang Diproses</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                 style="background: linear-gradient(135deg, #34d399, #10b981);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['selesai'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Selesai</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Recent Reports --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-slate-800">Laporan Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Semua laporan yang masuk</p>
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-700 whitespace-nowrap">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($laporanTerbaru as $l)
                    @php $sc=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700']; @endphp
                    <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $l->judul }}</p>
                            <div class="flex items-center gap-3 mt-0.5">
                                <span class="text-xs text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $l->lokasi ?? '-' }}
                                </span>
                                <span class="text-xs text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $l->created_at->diffForHumans() }}
                                </span>
                                <span class="text-xs text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    {{ $l->user->name }}
                                </span>
                            </div>
                        </div>
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $sc[$l->status] ?? 'bg-slate-100 text-slate-600' }} whitespace-nowrap">{{ ucfirst($l->status) }}</span>
                        @if($l->status === 'terkirim')
                        <a href="{{ route('admin.laporan.show', $l) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-colors whitespace-nowrap">
                            Verifikasi
                        </a>
                        @endif
                    </div>
                    @empty
                    <div class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada laporan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="space-y-4">

            {{-- Category Breakdown --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-slate-800">Kategori Laporan</h3>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div class="space-y-3">
                    @php
                        $barColors = ['bg-blue-600','bg-indigo-500','bg-cyan-500','bg-amber-500','bg-rose-500','bg-slate-400','bg-emerald-500'];
                        $totalKategori = $kategoriBreakdown->sum('count');
                    @endphp
                    @forelse($kategoriBreakdown as $i => $cat)
                    @php $pct = $totalKategori > 0 ? round(($cat['count'] / $totalKategori) * 100) : 0; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium text-slate-600">{{ $cat['nama'] }}</span>
                            <span class="text-xs text-slate-500">{{ $cat['count'] }} ({{ $pct }}%)</span>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full {{ $barColors[$i % count($barColors)] }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-400 text-sm text-center py-4">Belum ada data.</p>
                    @endforelse
                </div>
            </div>

            {{-- Pending Verification --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-3">Perlu Verifikasi</h3>
                @forelse($laporanMenunggu as $l)
                <div class="flex items-center justify-between p-3 bg-amber-50 border border-amber-100 rounded-xl mb-2 last:mb-0">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $l->judul }}</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">{{ $l->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.laporan.show', $l) }}" class="ml-2 text-xs font-semibold text-blue-600 bg-white border border-blue-200 px-2.5 py-1 rounded-lg hover:bg-blue-50 transition-colors flex-shrink-0 whitespace-nowrap">
                        Review
                    </a>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">Tidak ada laporan yang perlu diverifikasi</p>
                @endforelse
            </div>

            {{-- Bar Chart Bulanan --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-4 text-sm">Laporan per Bulan</h3>
                <canvas id="barChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('barChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($grafikBulanan->pluck('bulan')) !!},
        datasets: [{
            label: 'Laporan',
            data: {!! json_encode($grafikBulanan->pluck('total')) !!},
            backgroundColor: '#3B82F6',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endpush