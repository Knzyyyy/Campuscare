@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Tambah Kategori</h2>
        <form action="{{ route('superadmin.kategori.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Ikon <span class="text-slate-400 font-normal">(nama icon Heroicons)</span></label>
                <input type="text" name="ikon" value="{{ old('ikon') }}" placeholder="cth: wifi, trash, book" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                @error('ikon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Estimasi Penyelesaian (hari)</label>
                    <input type="number" name="estimasi_hari" value="{{ old('estimasi_hari', 3) }}" min="1" required
                        class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('estimasi_hari')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 1) }}" min="1" required
                        class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('urutan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-slate-300 text-blue-600">
                <label for="is_active" class="text-sm text-slate-700">Aktif</label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('superadmin.kategori.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium py-3 rounded-xl transition">Batal</a>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection