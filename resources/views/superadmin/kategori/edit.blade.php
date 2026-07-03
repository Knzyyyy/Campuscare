@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Edit Kategori</h2>
        <form action="{{ route('superadmin.kategori.update', $kategori) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Ikon</label>
                <input type="text" name="ikon" value="{{ old('ikon', $kategori->ikon) }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Estimasi (hari)</label>
                    <input type="number" name="estimasi_hari" value="{{ old('estimasi_hari', $kategori->estimasi_hari) }}" min="1" required
                        class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $kategori->urutan) }}" min="1" required
                        class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $kategori->is_active) ? 'checked' : '' }}
                    class="rounded border-slate-300 text-blue-600">
                <label for="is_active" class="text-sm text-slate-700">Aktif</label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('superadmin.kategori.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium py-3 rounded-xl transition">Batal</a>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection