@extends('layouts.app')
@section('title', 'Dashboard Super Admin')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Dashboard Super Admin</h2>
        <p class="text-slate-500 text-sm mt-1">Overview sistem CampusCare</p>
    </div>

    {{-- Stats User --}}
    <div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Pengguna Sistem</p>
        <div class="grid grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach([
                ['label'=>'Mahasiswa','val'=>$statsUser['mahasiswa'],'bg'=>'bg-blue-100','text'=>'text-blue-700'],
                ['label'=>'Dosen','val'=>$statsUser['dosen'],'bg'=>'bg-purple-100','text'=>'text-purple-700'],
                ['label'=>'Admin','val'=>$statsUser['admin'],'bg'=>'bg-indigo-100','text'=>'text-indigo-700'],
                ['label'=>'Staff','val'=>$statsUser['staff'],'bg'=>'bg-teal-100','text'=>'text-teal-700'],
                ['label'=>'Super Admin','val'=>$statsUser['super_admin'],'bg'=>'bg-slate-100','text'=>'text-slate-700'],
            ] as $c)
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center">
                <p class="text-2xl font-bold {{ $c['text'] }}">{{ $c['val'] }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $c['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Stats Laporan --}}
    <div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Laporan</p>
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach([
                ['label'=>'Total','val'=>$statsLaporan['total'],'text'=>'text-slate-700'],
                ['label'=>'Terkirim','val'=>$statsLaporan['terkirim'],'text'=>'text-blue-600'],
                ['label'=>'Diverifikasi','val'=>$statsLaporan['diverifikasi'],'text'=>'text-indigo-600'],
                ['label'=>'Diproses','val'=>$statsLaporan['diproses'],'text'=>'text-yellow-600'],
                ['label'=>'Selesai','val'=>$statsLaporan['selesai'],'text'=>'text-green-600'],
                ['label'=>'Ditolak','val'=>$statsLaporan['ditolak'],'text'=>'text-red-600'],
            ] as $c)
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center">
                <p class="text-2xl font-bold {{ $c['text'] }}">{{ $c['val'] }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $c['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Grafik --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <h3 class="font-semibold text-slate-700 text-sm mb-4">Laporan per Bulan</h3>
            <canvas id="barChart" height="180"></canvas>
        </div>

        {{-- User Terbaru --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-700 text-sm">User Terbaru</h3>
                <a href="{{ route('superadmin.users.index') }}" class="text-blue-600 text-xs hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @foreach($userTerbaru as $u)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $u->name }}</p>
                        <p class="text-xs text-slate-400">{{ $u->email }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 capitalize">{{ str_replace('_',' ',$u->role) }}</span>
                </div>
                @endforeach
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
        datasets: [{ label: 'Laporan', data: {!! json_encode($grafikBulanan->pluck('total')) !!}, backgroundColor: '#6366F1', borderRadius: 6 }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush