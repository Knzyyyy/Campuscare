<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi — CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#2563EB' },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen font-sans text-[14px] text-slate-800 antialiased">

    <div class="flex min-h-screen flex-col md:flex-row">

        {{-- Kolom KIRI --}}
        <div class="relative hidden w-full overflow-hidden md:flex md:w-[60%] flex-col bg-[#EEF4FC] min-h-screen">
            <div class="relative z-10 flex flex-col p-10 lg:p-12 pb-0">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="h-16 w-auto">
                    <div>
                        <p class="text-lg font-bold text-slate-900 leading-tight">Campus<span class="text-blue-500">Care</span></p>
                        <p class="text-xs text-slate-500">Layanan kampus, lebih mudah</p>
                    </div>
                </div>
                <div class="mt-16 max-w-xl">
                    <h1 class="text-[35px] font-extrabold leading-tight text-slate-900 tracking-tight lg:text-[45px]">
                        Buat Kata<br>Sandi Baru
                    </h1>
                    <p class="mt-6 text-[15px] leading-relaxed text-slate-600 max-w-md">
                        Pastikan kata sandi baru Anda kuat dan mudah diingat. Minimal 8 karakter.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-[65vh] overflow-hidden">
                <img src="{{ asset('assets/img/bsi.png') }}" alt="Ilustrasi kampus" class="w-full h-full object-cover object-center">
                <div class="absolute top-0 left-0 w-full h-48 bg-gradient-to-b from-[#EEF4FC] via-[#EEF4FC]/65 to-transparent"></div>
            </div>
        </div>

        {{-- Kolom KANAN --}}
        <div class="flex w-full flex-col items-center justify-center bg-[#F8FAFC] px-6 py-10 md:w-[40%] md:px-8 lg:px-10">
            <div class="w-full max-w-md md:rounded-2xl md:bg-white md:p-10 md:shadow-md">

                <div class="mb-6 flex justify-center">
                    <div class="flex h-[100px] w-[100px] items-center justify-center rounded-full">
                        <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo CampusCare" class="w-full h-full object-contain">
                    </div>
                </div>

                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-slate-900">Reset Kata Sandi</h2>
                    <p class="mt-1 text-sm text-slate-500">Buat kata sandi baru untuk akun Anda</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5" x-data="{ showPass: false, showConfirm: false }">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email (readonly) --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $email) }}"
                                required readonly
                                class="block w-full min-h-[44px] rounded-[10px] border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    {{-- Kata sandi baru --}}
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input :type="showPass ? 'text' : 'password'"
                                id="password" name="password"
                                placeholder="Minimal 8 karakter"
                                required
                                class="block w-full min-h-[44px] rounded-[10px] border border-slate-200 bg-white py-3 pl-11 pr-12 text-sm text-slate-800 placeholder-slate-400 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            <button type="button" @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-400 hover:text-slate-600">
                                <svg x-show="!showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi kata sandi --}}
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            <input :type="showConfirm ? 'text' : 'password'"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="Ulangi kata sandi baru"
                                required
                                class="block w-full min-h-[44px] rounded-[10px] border border-slate-200 bg-white py-3 pl-11 pr-12 text-sm text-slate-800 placeholder-slate-400 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-400 hover:text-slate-600">
                                <svg x-show="!showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full min-h-[52px] items-center justify-center gap-2 rounded-[10px] bg-primary text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kata Sandi Baru
                    </button>
                </form>

                <p class="mt-8 text-center text-xs text-blue-300">&copy; 2026 CampusCare. All rights reserved.</p>
            </div>
        </div>
    </div>

</body>
</html>
