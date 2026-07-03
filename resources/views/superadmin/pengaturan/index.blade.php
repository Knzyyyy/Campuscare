@extends('layouts.app')
@section('title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Pengaturan Sistem</h2>
        <form action="{{ route('superadmin.pengaturan.update') }}" method="POST" class="space-y-4">
            @csrf
            @foreach([
                ['key'=>'nama_aplikasi','label'=>'Nama Aplikasi','type'=>'text'],
                ['key'=>'tagline','label'=>'Tagline','type'=>'text'],
                ['key'=>'email_admin','label'=>'Email Admin','type'=>'email'],
                ['key'=>'sla_default_hari','label'=>'SLA Default (hari)','type'=>'number'],
                ['key'=>'max_upload_mb','label'=>'Maks. Upload (MB)','type'=>'number'],
                ['key'=>'max_foto_laporan','label'=>'Maks. Foto Laporan','type'=>'number'],
            ] as $f)
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ $f['label'] }}</label>
                <input type="{{ $f['type'] }}" name="{{ $f['key'] }}"
                    value="{{ $pengaturans[$f['key']]->nilai ?? '' }}"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            @endforeach
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition mt-2">
                Simpan Pengaturan
            </button>
        </form>
    </div>
</div>
@endsection