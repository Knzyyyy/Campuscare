@extends('layouts.app')
@section('title', 'FAQ')
@section('content')
<div class="max-w-2xl mx-auto space-y-3">
    <h2 class="text-xl font-bold text-slate-800">FAQ</h2>
    @foreach([
        ['q'=>'Berapa lama laporan diproses?','a'=>'Rata-rata 1-5 hari kerja tergantung kategori dan prioritas.'],
        ['q'=>'Bisa upload berapa foto?','a'=>'Maksimal 3 foto per laporan, ukuran maks. 2MB per file.'],
        ['q'=>'Laporan saya ditolak, apa yang harus dilakukan?','a'=>'Buat laporan baru dengan informasi yang lebih lengkap dan jelas.'],
    ] as $item)
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <p class="font-medium text-slate-700 text-sm">{{ $item['q'] }}</p>
        <p class="text-slate-500 text-sm mt-2">{{ $item['a'] }}</p>
    </div>
    @endforeach
</div>
@endsection