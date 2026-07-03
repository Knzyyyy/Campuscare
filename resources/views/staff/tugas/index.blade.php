@extends('layouts.app')
@section('title', 'Tugas Saya')

@section('content')
<div class="space-y-4">
    <h2 class="text-xl font-bold text-slate-800">Tugas Saya</h2>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Status Filter --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Status</label>
                <select name="status" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50/50 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all cursor-pointer" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="diproses" {{ request('status')==='diproses'?'selected':'' }}>Diproses</option>
                    <option value="selesai" {{ request('status')==='selesai'?'selected':'' }}>Selesai</option>
                </select>
            </div>

            {{-- Prioritas Filter --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Prioritas</label>
                <select name="prioritas" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50/50 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all cursor-pointer" onchange="this.form.submit()">
                    <option value="">Semua Prioritas</option>
                    <option value="tinggi" {{ request('prioritas')==='tinggi'?'selected':'' }}>🔴 Tinggi</option>
                    <option value="sedang" {{ request('prioritas')==='sedang'?'selected':'' }}>🟡 Sedang</option>
                    <option value="rendah" {{ request('prioritas')==='rendah'?'selected':'' }}>🟢 Rendah</option>
                </select>
            </div>

            {{-- Kategori Filter --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Kategori</label>
                <select name="kategori_id" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm bg-slate-50/50 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all cursor-pointer" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <div class="space-y-3">
        @forelse($laporans as $l)
        @php
            $sc=['diproses'=>'bg-yellow-100 text-yellow-700','selesai'=>'bg-green-100 text-green-700'];
            $pc=['rendah'=>'bg-green-100 text-green-700','sedang'=>'bg-yellow-100 text-yellow-700','tinggi'=>'bg-red-100 text-red-700'];
        @endphp
        <a href="{{ route('staff.tugas.show', $l) }}" class="block bg-white rounded-xl p-4 shadow-sm border border-slate-100 hover:border-blue-200 transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-mono text-slate-400 mb-1">{{ $l->nomor_laporan }}</p>
                    <p class="font-semibold text-slate-700 truncate">{{ $l->judul }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $l->kategori->nama ?? '-' }} · {{ $l->lokasi }}</p>
                    <p class="text-xs text-slate-400 font-medium">Ditugaskan {{ $l->assigned_at ? \Carbon\Carbon::parse($l->assigned_at)->diffForHumans() : '-' }}</p>
                    @if($l->status === 'selesai')
                        @if($l->rating)
                            <div class="flex items-center gap-1 mt-1.5 text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-full px-2 py-0.5 w-fit font-semibold">
                                <span>⭐ {{ $l->rating }}/5</span>
                            </div>
                        @else
                            <div class="flex items-center gap-1 mt-1.5 text-xs text-slate-400 bg-slate-50 border border-slate-100 rounded-full px-2 py-0.5 w-fit">
                                <span>Belum dinilai</span>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $sc[$l->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($l->status) }}</span>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $pc[$l->prioritas] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($l->prioritas) }}</span>
                </div>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-xl p-10 text-center text-slate-400 text-sm">Tidak ada tugas.</div>
        @endforelse
    </div>
    {{ $laporans->links() }}
</div>
@endsection