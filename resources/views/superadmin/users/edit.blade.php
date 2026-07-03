@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Edit User — {{ $user->name }}</h2>
        <form action="{{ route('superadmin.users.update', $user) }}" method="POST" class="space-y-4" x-data="{ role: '{{ old('role', $user->role) }}' }">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password <span class="text-slate-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" minlength="8"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Role</label>
                <select name="role" x-model="role" required
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    @foreach(['mahasiswa','dosen','admin_prodi','admin_fakultas','staff','super_admin'] as $r)
                    <option value="{{ $r }}" {{ old('role',$user->role)===$r?'selected':'' }}>{{ ucwords(str_replace('_',' ',$r)) }}</option>
                    @endforeach
                </select>
            </div>

            <div x-show="role === 'mahasiswa'">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">NIM</label>
                <input type="text" name="nim" value="{{ old('nim', $user->nim) }}"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div x-show="role && role !== 'mahasiswa'">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $user->nip) }}"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Fakultas</label>
                <select name="fakultas_id"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Tidak ada</option>
                    @foreach($fakultas as $f)
                    <option value="{{ $f->id }}" {{ old('fakultas_id',$user->fakultas_id)==$f->id?'selected':'' }}>{{ $f->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Prodi</label>
                <select name="prodi_id"
                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Tidak ada</option>
                    @foreach($prodis as $p)
                    <option value="{{ $p->id }}" {{ old('prodi_id',$user->prodi_id)==$p->id?'selected':'' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                    class="rounded border-slate-300 text-blue-600">
                <label for="is_active" class="text-sm text-slate-700">Akun Aktif</label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('superadmin.users.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium py-3 rounded-xl transition">Batal</a>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection