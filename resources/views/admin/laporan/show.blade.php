@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-3xl mx-auto space-y-4">
    <div class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.laporan.index') }}" class="hover:text-blue-600">Kelola Laporan</a>
        <span>›</span><span class="text-slate-700">Detail</span>
    </div>

    @php $sc=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700']; @endphp

    {{-- Info --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-start justify-between gap-3 mb-4">
            <h2 class="font-bold text-slate-800 text-lg">{{ $laporan->judul }}</h2>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $sc[$laporan->status] ?? '' }} whitespace-nowrap">{{ ucfirst($laporan->status) }}</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm mb-4">
            <div><p class="text-slate-400 text-xs mb-0.5">No. Laporan</p><p class="font-mono text-slate-700">{{ $laporan->nomor_laporan }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Pelapor</p><p class="text-slate-700">{{ $laporan->user->name }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Kategori</p><p class="text-slate-700">{{ $laporan->kategori->nama ?? '-' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Lokasi</p><p class="text-slate-700">{{ $laporan->lokasi }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Prioritas</p><p class="text-slate-700 capitalize">{{ $laporan->prioritas }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Tanggal</p><p class="text-slate-700">{{ $laporan->created_at->format('d M Y, H:i') }}</p></div>
        </div>
        <div class="pt-4 border-t border-slate-100">
            <p class="text-slate-400 text-xs mb-1">Deskripsi</p>
            <p class="text-slate-700 text-sm leading-relaxed">{{ $laporan->deskripsi }}</p>
        </div>
    </div>

    {{-- Foto --}}
    @if($laporan->lampirans->count())
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-3">Foto Lampiran</h3>
        <div class="grid grid-cols-3 gap-2">
            @foreach($laporan->lampirans as $foto)
            <img src="{{ Storage::url($foto->path) }}" class="w-full h-24 object-cover rounded-lg">
            @endforeach
        </div>
    </div>
    @endif

    {{-- Panel Aksi --}}
    @if($laporan->status === 'terkirim')
    <div class="bg-white rounded-xl p-6 shadow-sm border border-orange-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-4">Tindakan Verifikasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <form action="{{ route('admin.laporan.verifikasi', $laporan) }}" method="POST">
                @csrf
                <textarea name="keterangan" rows="3" placeholder="Keterangan verifikasi..." required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm mb-3 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                <button type="submit" class="w-full bg-blue-600 text-white text-sm py-2.5 rounded-lg hover:bg-blue-700 transition">✓ Verifikasi Laporan</button>
            </form>
            <form action="{{ route('admin.laporan.tolak', $laporan) }}" method="POST">
                @csrf
                <textarea name="keterangan" rows="3" placeholder="Alasan penolakan..." required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm mb-3 resize-none focus:ring-2 focus:ring-red-500"></textarea>
                <button type="submit" class="w-full bg-red-500 text-white text-sm py-2.5 rounded-lg hover:bg-red-600 transition">✕ Tolak Laporan</button>
            </form>
        </div>
    </div>
    @endif

    @if($laporan->status === 'diverifikasi')
    <div class="bg-white rounded-xl p-6 shadow-sm border border-indigo-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-4">Tugaskan ke Staff</h3>
        <form action="{{ route('admin.laporan.assign', $laporan) }}" method="POST" class="flex gap-3">
            @csrf
            <select name="staff_id" required class="flex-1 border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih staff...</option>
                @foreach($staffList as $staff)
                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white text-sm px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition whitespace-nowrap">Tugaskan</button>
        </form>
    </div>
    @endif

    {{-- Timeline --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-4">Riwayat Status</h3>
        <div class="space-y-3">
            @foreach($laporan->statusLogs as $log)
            @php $dc=['terkirim'=>'bg-blue-500','diverifikasi'=>'bg-indigo-500','diproses'=>'bg-yellow-500','selesai'=>'bg-green-500','ditolak'=>'bg-red-500']; @endphp
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-3 h-3 rounded-full mt-1 {{ $dc[$log->status_baru] ?? 'bg-slate-400' }}"></div>
                    @if(!$loop->last)<div class="w-0.5 flex-1 bg-slate-200 my-1 min-h-4"></div>@endif
                </div>
                <div class="pb-3">
                    <p class="text-xs text-slate-400">{{ $log->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm font-medium text-slate-700 capitalize">{{ $log->status_baru }}</p>
                    @if($log->keterangan)<p class="text-xs text-slate-500 mt-0.5">{{ $log->keterangan }}</p>@endif
                    @if($log->user)<p class="text-xs text-slate-400">oleh {{ $log->user->name }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection