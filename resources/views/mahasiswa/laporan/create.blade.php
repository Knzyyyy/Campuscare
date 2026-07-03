@extends('layouts.app')
@section('title', 'Buat Laporan')

@section('content')
<div class="max-w-2xl mx-auto"
     x-data="createReport()">

    {{-- Step Indicator --}}
    <!-- Desktop/Tablet View -->
    <div class="hidden sm:flex items-center gap-2 mb-8">
        <template x-for="(s, i) in steps" :key="i">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold transition-all"
                     :class="i < step ? 'bg-green-100 text-green-700' : i === step ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-400'">
                    <template x-if="i < step">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </template>
                    <template x-if="i >= step">
                        <span class="w-4 text-center" x-text="i + 1"></span>
                    </template>
                    <span x-text="s"></span>
                </div>
                <svg x-show="i < steps.length - 1" class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </template>
    </div>

    <!-- Mobile View (Horizontal Progress Bar) -->
    <div class="block sm:hidden mb-6 bg-white rounded-2xl border border-slate-100 p-4 shadow-sm">
        <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">
            <span x-text="`Langkah ${step + 1} dari ${steps.length}`"></span>
            <span class="text-blue-600" x-text="steps[step]"></span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                 :style="`width: ${((step + 1) / steps.length) * 100}%`"></div>
        </div>
    </div>

    <form action="{{ route('mahasiswa.laporan.store') }}" method="POST" enctype="multipart/form-data" @submit="loading = true">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800" x-text="stepTitles[step]"></h2>
                <p class="text-sm text-slate-500 mt-0.5" x-text="stepDesc[step]"></p>
            </div>

            <div class="p-6">

                {{-- STEP 0: Kategori --}}
                <div x-show="step === 0">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($kategoris as $k)
                        <button type="button" @click="kategori_id = '{{ $k->id }}'; kategori_nama = '{{ $k->nama }}'"
                            class="p-4 rounded-xl border-2 text-sm font-semibold text-left transition-all"
                            :class="kategori_id === '{{ $k->id }}' ? 'border-blue-600 bg-blue-50 text-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:border-blue-200 hover:bg-slate-50'">
                            {{ $k->nama }}
                        </button>
                        @endforeach
                    </div>
                    @error('kategori_id')<p class="text-red-500 text-xs mt-3">{{ $message }}</p>@enderror
                </div>

                {{-- STEP 1: Detail --}}
                <div x-show="step === 1" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Laporan *</label>
                        <input type="text" x-model="judul" placeholder="Deskripsikan masalah secara singkat..."
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all">
                        @error('judul')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lokasi *</label>
                        <input type="text" x-model="lokasi" placeholder="Contoh: Gedung A, Lantai 3, Ruang 301"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all">
                        @error('lokasi')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap *</label>
                        <textarea x-model="deskripsi" rows="4" placeholder="Jelaskan masalah secara detail. Kapan terjadi, seberapa parah, dampaknya..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-[3px] focus:ring-blue-100 transition-all resize-none"></textarea>
                        @error('deskripsi')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prioritas</label>
                        <div class="flex gap-2">
                            <template x-for="p in ['rendah','sedang','tinggi']" :key="p">
                                <button type="button" @click="prioritas = p"
                                    class="flex-1 py-2 px-3 rounded-xl border-2 text-sm font-semibold transition-all capitalize"
                                    :class="prioritas === p
                                        ? (p === 'tinggi' ? 'border-red-500 bg-red-50 text-red-700'
                                          : p === 'sedang' ? 'border-amber-500 bg-amber-50 text-amber-700'
                                          : 'border-green-500 bg-green-50 text-green-700')
                                        : 'border-slate-200 text-slate-500 hover:border-slate-300'"
                                    x-text="p"></button>
                            </template>
                        </div>
                        @error('prioritas')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Pendukung (opsional, maks. 3)</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-colors cursor-pointer"
                             @click="$refs.fotoInput.click()">
                            <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-slate-500">Klik atau seret foto ke sini</p>
                            <p class="text-xs text-slate-400 mt-1">JPG, PNG maksimal 2MB per file</p>
                        </div>
                        <input type="file" name="foto[]" multiple accept="image/*" x-ref="fotoInput" class="hidden" @change="handleFiles($event)">

                        <div class="grid grid-cols-3 gap-2 mt-3" x-show="previews.length > 0">
                            <template x-for="(src, i) in previews" :key="i">
                                <div class="relative">
                                    <img :src="src" class="w-full h-24 object-cover rounded-lg">
                                    <button type="button" @click="removeFile(i)"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">×</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Konfirmasi --}}
                <div x-show="step === 2" class="space-y-4">
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 space-y-3">
                        <div class="flex justify-between gap-4">
                            <span class="text-sm text-slate-500 font-medium">Kategori</span>
                            <span class="text-sm font-semibold text-slate-800 text-right" x-text="kategori_nama || '-'"></span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-sm text-slate-500 font-medium">Judul</span>
                            <span class="text-sm font-semibold text-slate-800 text-right max-w-52 truncate" x-text="judul || '-'"></span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-sm text-slate-500 font-medium">Lokasi</span>
                            <span class="text-sm font-semibold text-slate-800 text-right" x-text="lokasi || '-'"></span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-sm text-slate-500 font-medium">Prioritas</span>
                            <span class="text-sm font-semibold text-slate-800 capitalize" x-text="prioritas"></span>
                        </div>
                        <div class="pt-2 border-t border-slate-200">
                            <span class="text-sm text-slate-500 font-medium block mb-1">Deskripsi</span>
                            <p class="text-sm text-slate-700" x-text="deskripsi || '-'"></p>
                        </div>
                        <div class="pt-2 border-t border-slate-200" x-show="previews.length > 0">
                            <span class="text-sm text-slate-500 font-medium block mb-2">Foto (<span x-text="previews.length"></span>)</span>
                            <div class="grid grid-cols-3 gap-2">
                                <template x-for="src in previews" :key="src">
                                    <img :src="src" class="w-full h-16 object-cover rounded-lg">
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Pastikan informasi sudah benar</p>
                            <p class="text-xs text-blue-600 mt-0.5">Laporan yang sudah dikirim tidak dapat diubah. Admin akan memverifikasi laporan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <template x-if="step > 0">
                    <button type="button" @click="step--" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-colors">
                        Kembali
                    </button>
                </template>
                <template x-if="step === 0">
                    <a href="{{ route('mahasiswa.laporan.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-colors">
                        Batal
                    </a>
                </template>

                <template x-if="step < 2">
                    <button type="button" @click="step++" :disabled="step === 0 && !kategori_id"
                        class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl font-semibold text-sm hover:bg-blue-700 transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:-translate-y-0.5 hover:shadow-md hover:shadow-blue-200">
                        Lanjutkan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </template>
                <template x-if="step === 2">
                    <button type="submit" :disabled="loading"
                        class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold text-sm hover:bg-blue-700 transition-all hover:-translate-y-0.5 hover:shadow-md hover:shadow-blue-200 disabled:opacity-60">
                        <div x-show="loading" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        Kirim Laporan
                    </button>
                </template>
            </div>
        </div>

        {{-- Hidden inputs (mirror Alpine state untuk submit) --}}
        <input type="hidden" name="kategori_id" :value="kategori_id">
        <input type="hidden" name="judul" :value="judul">
        <input type="hidden" name="lokasi" :value="lokasi">
        <input type="hidden" name="deskripsi" :value="deskripsi">
        <input type="hidden" name="prioritas" :value="prioritas">
    </form>
</div>
@endsection

@push('scripts')
<script>
function createReport() {
    return {
        step: 0,
        steps: ['Kategori', 'Detail Laporan', 'Konfirmasi'],
        stepTitles: ['Pilih Kategori Laporan', 'Isi Detail Laporan', 'Konfirmasi & Kirim'],
        stepDesc: [
            'Pilih kategori yang paling sesuai dengan laporan Anda',
            'Berikan informasi selengkap mungkin',
            'Periksa kembali laporan sebelum mengirim'
        ],
        loading: false,
        kategori_id: '{{ old('kategori_id') }}',
        kategori_nama: '',
        judul: '{{ old('judul') }}',
        lokasi: '{{ old('lokasi') }}',
        deskripsi: `{{ old('deskripsi') }}`,
        prioritas: '{{ old('prioritas', 'sedang') }}',
        previews: [],
        files: [],

        init() {
            // Jika validasi gagal & ada old kategori, isi nama kategorinya
            const map = {!! $kategoris->pluck('nama','id')->toJson() !!};
            if (this.kategori_id && map[this.kategori_id]) {
                this.kategori_nama = map[this.kategori_id];
            }
            // Jika ada error validasi, langsung lompat ke step yang relevan
            @if($errors->has('kategori_id'))
                this.step = 0;
            @elseif($errors->has('judul') || $errors->has('lokasi') || $errors->has('deskripsi') || $errors->has('prioritas'))
                this.step = 1;
            @endif
        },

        handleFiles(e) {
            const newFiles = Array.from(e.target.files);
            if (this.files.length + newFiles.length > 3) {
                alert('Maksimal 3 foto!'); return;
            }
            newFiles.forEach(f => {
                this.files.push(f);
                const reader = new FileReader();
                reader.onload = (ev) => this.previews.push(ev.target.result);
                reader.readAsDataURL(f);
            });
        },
        removeFile(i) {
            this.previews.splice(i, 1);
            this.files.splice(i, 1);
        }
    }
}
</script>
@endpush