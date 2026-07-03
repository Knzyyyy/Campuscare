@extends('layouts.app')
@section('title', 'Detail Tugas')

@section('content')
<div class="max-w-2xl mx-auto space-y-4" x-data="{ zoomModal: null }">
    <div class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('staff.tugas.index') }}" class="hover:text-blue-600">Tugas Saya</a>
        <span>›</span><span class="text-slate-700">Detail</span>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-start justify-between gap-3 mb-4">
            <h2 class="font-bold text-slate-800 text-lg">{{ $laporan->judul }}</h2>
            @if($laporan->status === 'diproses')
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Diproses</span>
            @else
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-slate-400 text-xs mb-0.5">No. Laporan</p><p class="font-mono text-slate-700">{{ $laporan->nomor_laporan }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Pelapor</p><p class="text-slate-700">{{ $laporan->user->name }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Kategori</p><p class="text-slate-700">{{ $laporan->kategori->nama ?? '-' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Lokasi</p><p class="text-slate-700">{{ $laporan->lokasi }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Prioritas</p><p class="text-slate-700 capitalize">{{ $laporan->prioritas }}</p></div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100">
            <p class="text-slate-400 text-xs mb-1">Deskripsi</p>
            <p class="text-slate-700 text-sm leading-relaxed">{{ $laporan->deskripsi }}</p>
        </div>
    </div>

    {{-- Foto lampiran awal --}}
    @if($laporan->lampirans->where('tipe','lampiran_awal')->count())
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-3">Foto dari Pelapor</h3>
        <div class="grid grid-cols-3 gap-2">
            @foreach($laporan->lampirans->where('tipe','lampiran_awal') as $f)
            <img src="{{ Storage::url($f->path) }}" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                 @click="zoomModal = '{{ Storage::url($f->path) }}'">
            @endforeach
        </div>
    </div>
    @endif

    {{-- Foto Bukti Penyelesaian --}}
    @if($laporan->lampirans->where('tipe','bukti_penyelesaian')->count())
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-3">Foto Bukti Penyelesaian</h3>
        <div class="grid grid-cols-3 gap-2">
            @foreach($laporan->lampirans->where('tipe','bukti_penyelesaian') as $foto)
            <img src="{{ Storage::url($foto->path) }}" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                 @click="zoomModal = '{{ Storage::url($foto->path) }}'">
            @endforeach
        </div>
    </div>
    @endif

    {{-- Penilaian Pelapor --}}
    @if($laporan->status === 'selesai')
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-3">Penilaian Pelapor</h3>
        @if($laporan->rating)
            <div class="flex items-center gap-1 mb-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= $laporan->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200 fill-slate-200' }}" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                @endfor
                <span class="text-sm font-semibold text-slate-700 ml-1">({{ $laporan->rating }}/5)</span>
            </div>
            @if($laporan->feedback)
                <p class="text-sm text-slate-600 italic bg-slate-50 p-3 rounded-lg border border-slate-100">"{{ $laporan->feedback }}"</p>
            @else
                <p class="text-sm text-slate-400 italic">Tidak ada komentar.</p>
            @endif
        @else
            <p class="text-sm text-slate-500 italic">Belum ada penilaian dari pelapor.</p>
        @endif
    </div>
    @endif

    {{-- Timeline --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-3">Riwayat Status</h3>
        @foreach($laporan->statusLogs as $log)
        @php $dc=['terkirim'=>'bg-blue-500','diverifikasi'=>'bg-indigo-500','diproses'=>'bg-yellow-500','selesai'=>'bg-green-500','ditolak'=>'bg-red-500']; @endphp
        <div class="flex gap-3 mb-3">
            <div class="w-3 h-3 rounded-full mt-1 flex-shrink-0 {{ $dc[$log->status_baru] ?? 'bg-slate-400' }}"></div>
            <div>
                <p class="text-xs text-slate-400">{{ $log->created_at->format('d M Y, H:i') }}</p>
                <p class="text-sm font-medium text-slate-700 capitalize">{{ $log->status_baru }}</p>
                @if($log->keterangan)<p class="text-xs text-slate-500">{{ $log->keterangan }}</p>@endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Form Selesai --}}
    @if($laporan->status === 'diproses')
    <div class="bg-white rounded-xl p-6 shadow-sm border border-green-100">
        <h3 class="font-semibold text-slate-700 text-sm mb-4">Tandai Selesai</h3>
        <form action="{{ route('staff.tugas.selesai', $laporan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan Penyelesaian <span class="text-red-500">*</span></label>
                <textarea name="keterangan" rows="3" required placeholder="Jelaskan apa yang sudah diperbaiki..."
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 resize-none"></textarea>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Bukti (opsional, maks. 3)</label>
                <input type="file" name="bukti[]" multiple accept="image/*"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-slate-100 file:text-slate-700">
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-3 rounded-xl transition">
                ✓ Tandai Selesai
            </button>
        </form>
    </div>
    @endif
    {{-- Modal zoom --}}
    <div x-show="zoomModal" @click="zoomModal=null" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
        <img :src="zoomModal" class="max-w-full max-h-full rounded-xl">
    </div>
</div>
@endsection