@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ confirmHapus: false }">

    {{-- Back + Header --}}
    <div>
        <a href="{{ route('mahasiswa.laporan.index') }}"
           class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600 font-medium transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Laporan
        </a>

        @php
            $colors=['terkirim'=>'bg-blue-100 text-blue-700','diverifikasi'=>'bg-indigo-100 text-indigo-700','diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700'];
            $pc=['rendah'=>'bg-green-100 text-green-700','sedang'=>'bg-amber-100 text-amber-700','tinggi'=>'bg-red-100 text-red-700'];
        @endphp

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <span class="text-xs font-mono text-slate-400">{{ $laporan->nomor_laporan }}</span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $colors[$laporan->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($laporan->status) }}</span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full capitalize {{ $pc[$laporan->prioritas] ?? 'bg-slate-100 text-slate-600' }}">{{ $laporan->prioritas }}</span>
                </div>
                <h2 class="text-xl font-bold text-slate-800">{{ $laporan->judul }}</h2>
            </div>

            {{-- Tombol hapus hanya saat status terkirim --}}
            @if($laporan->status === 'terkirim')
            <button @click="confirmHapus = true"
                class="flex items-center gap-1.5 text-sm text-red-600 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition whitespace-nowrap w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus Laporan
            </button>
            @endif
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div x-show="confirmHapus" x-transition.opacity
        class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display:none">
        <div @click.stop class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-center mb-1">Hapus Laporan?</h3>
            <p class="text-sm text-slate-500 text-center mb-5">Laporan <strong>{{ $laporan->nomor_laporan }}</strong> akan dihapus permanen beserta semua lampirannya.</p>
            <div class="flex gap-3">
                <button @click="confirmHapus = false"
                    class="flex-1 border border-slate-200 text-slate-600 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition">
                    Batal
                </button>
                <form action="{{ route('mahasiswa.laporan.destroy', $laporan) }}" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 text-white py-2.5 rounded-xl text-sm font-medium hover:bg-red-700 transition">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Detail + Timeline --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Detail Card --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Detail Laporan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Kategori</p>
                            <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-sm font-medium text-slate-700 rounded-full">
                                {{ $laporan->kategori->nama ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Kirim</p>
                            <p class="text-sm font-semibold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $laporan->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Lokasi</p>
                            <p class="text-sm font-semibold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $laporan->lokasi }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Pelapor</p>
                            <p class="text-sm font-semibold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $laporan->user->name ?? auth()->user()->name }}
                            </p>
                        </div>
                        @if($laporan->assignedStaff)
                        <div class="col-span-2">
                            <p class="text-xs text-slate-500 font-medium mb-1">Ditangani oleh</p>
                            <p class="text-sm font-semibold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                {{ $laporan->assignedStaff->name }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-medium mb-2">Deskripsi</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $laporan->deskripsi }}</p>
                    </div>
                </div>
            </div>

            {{-- Foto Lampiran --}}
            @if($laporan->lampirans->where('tipe','lampiran_awal')->count())
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6" x-data="{ modal: null }">
                <h3 class="font-semibold text-slate-800 text-sm mb-3">Foto Lampiran</h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($laporan->lampirans->where('tipe','lampiran_awal') as $foto)
                    <img src="{{ Storage::url($foto->path) }}" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                         @click="modal = '{{ Storage::url($foto->path) }}'">
                    @endforeach
                </div>
                <div x-show="modal" @click="modal=null" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
                    <img :src="modal" class="max-w-full max-h-full rounded-xl">
                </div>
            </div>
            @endif

            {{-- Foto Bukti Penyelesaian --}}
            @if($laporan->lampirans->where('tipe','bukti_penyelesaian')->count())
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6" x-data="{ modal: null }">
                <h3 class="font-semibold text-slate-800 text-sm mb-3">Bukti Penyelesaian</h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($laporan->lampirans->where('tipe','bukti_penyelesaian') as $foto)
                    <img src="{{ Storage::url($foto->path) }}" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-90"
                         @click="modal = '{{ Storage::url($foto->path) }}'">
                    @endforeach
                </div>
                <div x-show="modal" @click="modal=null" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
                    <img :src="modal" class="max-w-full max-h-full rounded-xl">
                </div>
            </div>
            @endif

            {{-- Timeline Status --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Timeline Status</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Riwayat perjalanan laporan Anda</p>
                </div>
                <div class="p-6">
                    <div class="relative">
                        @php $totalLogs = $laporan->statusLogs->count(); @endphp
                        @foreach($laporan->statusLogs as $log)
                        @php
                            $isLast = $loop->last;
                            $isCurrent = $isLast;
                        @endphp
                        <div class="flex gap-4 relative">
                            {{-- Connector --}}
                            @if(!$isLast)
                            <div class="absolute left-3.5 top-8 w-0.5 bg-blue-500" style="height: calc(100% - 8px)"></div>
                            @endif

                            {{-- Node --}}
                            <div class="relative flex-shrink-0 mt-0.5">
                                @if(!$isCurrent)
                                <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                @else
                                <div class="w-7 h-7 rounded-full border-2 border-blue-600 bg-white flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></div>
                                </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 {{ !$isLast ? 'pb-8' : 'pb-0' }}">
                                <p class="text-sm font-semibold {{ $isCurrent ? 'text-blue-700' : 'text-slate-800' }} capitalize">
                                    {{ $log->status_baru }}
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                @if($log->user)
                                <p class="text-xs text-slate-500 mt-0.5">{{ $log->user->name }}</p>
                                @endif
                                @if($log->keterangan)
                                <p class="text-xs mt-2 px-3 py-2 rounded-lg {{ $isCurrent ? 'bg-blue-50 text-blue-700' : 'bg-slate-50 text-slate-600' }}">
                                    {{ $log->keterangan }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="space-y-4">

            {{-- Rating Card --}}
            @if($laporan->status === 'selesai' && !$laporan->rating)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5" x-data="{ rating: 0, hover: 0 }">
                <h3 class="font-semibold text-slate-800 mb-1">Beri Penilaian</h3>
                <p class="text-sm text-slate-500 mb-3">Bagaimana penanganan laporan ini?</p>
                <form action="{{ route('mahasiswa.laporan.rating', $laporan) }}" method="POST">
                    @csrf
                    <div class="flex gap-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="rating = {{ $i }}" @mouseover="hover = {{ $i }}" @mouseleave="hover = 0"
                            class="w-9 h-9 rounded-lg hover:bg-amber-50 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 transition" :class="(hover || rating) >= {{ $i }} ? 'text-amber-400 fill-amber-400' : 'text-slate-200 fill-slate-200'" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" :value="rating">
                    <textarea name="feedback" rows="3" placeholder="Berikan komentar (opsional)..."
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all resize-none"></textarea>
                    <button type="submit" x-show="rating > 0"
                        class="w-full mt-3 py-2 bg-blue-600 text-white rounded-xl font-semibold text-sm hover:bg-blue-700 transition-colors">
                        Kirim Penilaian
                    </button>
                </form>
            </div>
            @elseif($laporan->rating)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-2">Penilaian Anda</h3>
                <div class="flex gap-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= $laporan->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200 fill-slate-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    @endfor
                </div>
                @if($laporan->feedback)
                <p class="text-sm text-slate-600 italic">"{{ $laporan->feedback }}"</p>
                @endif
            </div>
            @endif

            {{-- Ringkasan --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-3">Ringkasan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Status</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$laporan->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($laporan->status) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Kategori</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $laporan->kategori->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Tanggal Kirim</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $laporan->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Update Terakhir</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $laporan->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Bantuan --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-blue-800 mb-1">Butuh bantuan?</p>
                <p class="text-xs text-blue-600">Hubungi admin atau lihat panduan pengguna untuk informasi lebih lanjut.</p>
                <a href="{{ route('mahasiswa.panduan') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-700 mt-2 hover:text-blue-800">
                    Lihat Panduan
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection