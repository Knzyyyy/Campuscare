@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Welcome Banner --}}
    <div class="rounded-2xl p-6 text-white relative overflow-hidden shadow-lg"
         style="background: linear-gradient(135deg, #1e3a8a 0%, #2563EB 60%, #1d4ed8 100%);">
        <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10"></div>
        <div class="absolute -right-4 -bottom-12 w-32 h-32 rounded-full bg-white/5"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-blue-200 text-sm font-medium mb-1">Selamat datang kembali,</p>
                <h2 class="text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h2>
                <p class="text-blue-200 text-sm mt-1">{{ auth()->user()->email }}</p>
            </div>
            <a href="{{ route('mahasiswa.laporan.create') }}"
               class="flex items-center gap-2 bg-white text-blue-700 px-4 py-2.5 rounded-xl font-semibold text-sm hover:bg-blue-50 transition-colors shadow-sm whitespace-nowrap w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Laporan --}}
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #3b82f6, #2563EB);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $totalLaporan }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Total Laporan</p>
        </div>

        {{-- Laporan Aktif (Diproses) --}}
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #fbbf24, #f59e0b);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $diproses }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Sedang Diproses</p>
        </div>

        {{-- Selesai --}}
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #34d399, #10b981);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $selesai }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Selesai</p>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #fb7185, #ef4444);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $ditolak }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Ditolak</p>
        </div>
    </div>

    {{-- Row 2: Laporan Terbaru + Sidebar (Aksi Cepat & Panduan Status) --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Laporan Terbaru --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-slate-800">Laporan Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Riwayat pengiriman laporan Anda</p>
                    </div>
                    <a href="{{ route('mahasiswa.laporan.index') }}"
                       class="flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($laporanTerbaru as $laporan)
                    @php
                        $colors = ['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700'];
                        $c = $colors[$laporan->status] ?? 'bg-slate-100 text-slate-600';
                    @endphp
                    <a href="{{ route('mahasiswa.laporan.show', $laporan) }}"
                       class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-sm font-semibold text-slate-800 group-hover:text-blue-700 transition-colors truncate">
                                    {{ $laporan->judul }}
                                </p>
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $c }} whitespace-nowrap flex-shrink-0">{{ ucfirst($laporan->status) }}</span>
                            </div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="flex items-center gap-1 text-xs text-slate-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $laporan->lokasi ?? '-' }}
                                </span>
                                <span class="flex items-center gap-1 text-xs text-slate-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $laporan->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada laporan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar: Aksi Cepat + Panduan Status --}}
        <div class="space-y-4">

            {{-- Aksi Cepat --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('mahasiswa.laporan.create') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-xl bg-blue-600 text-white font-medium text-sm hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Laporan Baru
                    </a>
                    <a href="{{ route('mahasiswa.laporan.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-xl bg-slate-50 text-slate-700 font-medium text-sm hover:bg-slate-100 transition-colors border border-slate-100">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Lihat Semua Laporan
                    </a>
                </div>
            </div>

            {{-- Panduan Status --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Panduan Status</h3>
                <div class="space-y-2.5">
                    @foreach([
                        ['status'=>'terkirim','label'=>'Terkirim','desc'=>'Menunggu verifikasi','color'=>'bg-blue-100 text-blue-700'],
                        ['status'=>'diverifikasi','label'=>'Diverifikasi','desc'=>'Sudah diverifikasi admin','color'=>'bg-indigo-100 text-indigo-700'],
                        ['status'=>'diproses','label'=>'Diproses','desc'=>'Staff sedang menangani','color'=>'bg-yellow-100 text-yellow-700'],
                        ['status'=>'selesai','label'=>'Selesai','desc'=>'Selesai ditangani','color'=>'bg-green-100 text-green-700'],
                        ['status'=>'ditolak','label'=>'Ditolak','desc'=>'Tidak memenuhi syarat','color'=>'bg-red-100 text-red-700'],
                    ] as $s)
                    <div class="flex items-center gap-3">
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $s['color'] }} whitespace-nowrap">{{ $s['label'] }}</span>
                        <span class="text-xs text-slate-500">{{ $s['desc'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Donut Chart Kategori --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 mb-4 text-sm">Laporan per Kategori</h3>
                @if($dataGrafik->isEmpty())
                    <p class="text-slate-400 text-sm text-center py-8">Belum ada data laporan.</p>
                @else
                    <canvas id="donutChart" height="200"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(!$dataGrafik->isEmpty())
<script>
const ctx = document.getElementById('donutChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($dataGrafik->keys()) !!},
        datasets: [{
            data: {!! json_encode($dataGrafik->values()) !!},
            backgroundColor: ['#3B82F6','#10B981','#F59E0B','#6366F1','#EF4444','#8B5CF6','#14B8A6'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12 } } },
        cutout: '65%',
    },
    plugins: [{
        id: 'centerText',
        beforeDraw(chart) {
            const { width, height, ctx } = chart;
            const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
            const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

            ctx.save();

            // Angka total — besar & bold
            ctx.font = 'bold 28px system-ui, sans-serif';
            ctx.fillStyle = '#1e293b';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('{{ $totalLaporan }}', centerX, centerY - 10);

            // Label kecil di bawah angka
            ctx.font = '12px system-ui, sans-serif';
            ctx.fillStyle = '#94a3b8';
            ctx.fillText('Laporan', centerX, centerY + 16);

            ctx.restore();
        }
    }]
});
</script>
@endif
@endpush