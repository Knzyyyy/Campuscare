@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-2">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Notifikasi</h2>
            @php $unreadCount = $notifikasis->where('is_read', false)->count(); @endphp
            <p class="text-sm text-slate-500 mt-0.5">
                @if($unreadCount > 0)
                    {{ $unreadCount }} notifikasi belum dibaca
                @else
                    Semua notifikasi sudah dibaca
                @endif
            </p>
        </div>
        @if($unreadCount > 0)
        <form action="{{ route('admin.notifikasi.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 px-4 py-2 rounded-xl hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    {{-- Notifications --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @forelse($notifikasis as $n)
        <div class="p-5 transition-colors {{ !$n->is_read ? 'bg-blue-50/40 hover:bg-blue-50' : 'hover:bg-slate-50' }} {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ !$n->is_read ? 'bg-blue-100' : 'bg-slate-100' }}">
                    <svg class="w-5 h-5 {{ !$n->is_read ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-slate-800">{{ $n->judul }}</p>
                            @if(!$n->is_read)
                            <span class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>
                            @endif
                        </div>
                        <span class="text-xs text-slate-400 flex-shrink-0 whitespace-nowrap">{{ $n->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ $n->pesan }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        @if($n->laporan_id)
                        <a href="{{ route('admin.notifikasi.read', $n->id) }}"
                           class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700">
                            Lihat Laporan
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        @endif
                        @if(!$n->is_read)
                        <form action="{{ route('admin.notifikasi.read', $n->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-slate-400 hover:text-slate-600 font-medium">
                                Tandai dibaca
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h3 class="text-base font-semibold text-slate-600 mb-1">Tidak ada notifikasi</h3>
            <p class="text-sm text-slate-400">Anda akan mendapat notifikasi saat ada laporan baru</p>
        </div>
        @endforelse
    </div>

    @if($notifikasis->count())
    {{ $notifikasis->links() }}
    @endif
</div>
@endsection