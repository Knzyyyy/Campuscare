@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Tambah User</h2>
        <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-4" x-data="{ role: '{{ old('role') }}' }">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                <input type="password" name="password" required minlength="8"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Role</label>
                <select name="role" x-model="role" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih role</option>
                    @foreach(['mahasiswa','dosen','admin_prodi','admin_fakultas','staff','super_admin'] as $r)
                    <option value="{{ $r }}" {{ old('role')===$r?'selected':'' }}>{{ ucwords(str_replace('_',' ',$r)) }}</option>
                    @endforeach
                </select>
            </div>

            <div x-show="role === 'mahasiswa'">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div x-show="role && role !== 'mahasiswa'">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Fakultas</label>
                <select name="fakultas_id"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih fakultas (opsional)</option>
                    @foreach($fakultas as $f)
                    <option value="{{ $f->id }}" {{ old('fakultas_id')==$f->id?'selected':'' }}>{{ $f->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Prodi</label>
                <select name="prodi_id"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih prodi (opsional)</option>
                    @foreach($prodis as $p)
                    <option value="{{ $p->id }}" {{ old('prodi_id')==$p->id?'selected':'' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('superadmin.users.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium py-3 rounded-xl transition">Batal</a>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection