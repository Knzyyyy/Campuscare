<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — CampusCare</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 300: '#93c5fd',
                            500: '#3b82f6', 600: '#2563EB', 700: '#1d4ed8',
                        },
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: 0, transform: 'translateY(12px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        },
                    },
                },
            },
        };
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .gradient-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563EB 50%, #1d4ed8 100%);
        }
    </style>
</head>
<body class="min-h-screen font-sans text-[14px] text-slate-800 antialiased">

    <div class="flex min-h-screen">

        {{-- LEFT — Brand Hero --}}
        <div class="hidden lg:flex lg:w-1/2 gradient-hero flex-col justify-between p-12 relative overflow-hidden">
            {{-- Decorative blobs --}}
            <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-white/[0.06] blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-blue-400/20 blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-blue-500/10 blur-3xl"></div>

            {{-- Logo --}}
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-16 h-16  flex items-center justify-center bg-white rounded-lg">
                        <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo">
                    </div>
                    <span class="text-white text-xl font-bold tracking-tight">
                        Campus<span class="text-blue-300">Care</span>
                    </span>
                </div>
            </div>

            {{-- Konten utama --}}
            <div class="relative z-10 space-y-6">
                <div>
                    <h1 class="text-5xl font-bold text-white leading-tight tracking-tight">
                        Layanan kampus,<br>
                        <span class="text-blue-300">lebih mudah.</span>
                    </h1>
                    <p class="text-white/75 text-lg mt-4 leading-relaxed font-light max-w-md">
                        Sampaikan laporan, pantau progres, dan dapatkan solusi — semua dalam satu platform terintegrasi.
                    </p>
                </div>

                {{-- Feature pills --}}
                <div class="flex flex-col gap-3">
                    @foreach([
                        'Laporan masalah fasilitas kampus',
                        'Monitoring status penanganan real-time',
                        'Notifikasi otomatis setiap update',
                    ] as $feature)
                    <div class="flex items-center gap-3 bg-white/10 border border-white/20 rounded-full px-4 py-2.5 backdrop-blur-sm w-fit">
                        <svg class="w-4 h-4 text-green-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-white/90 text-sm font-medium">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-white/40 text-xs">&copy; 2026 CampusCare. All rights reserved.</p>
            </div>
        </div>

        {{-- RIGHT — Form --}}
        <div class="flex-1 lg:w-1/2 bg-white flex items-center justify-center p-6 md:p-8">
            <div class="w-full max-w-md animate-fade-in-up">

                {{-- Mobile logo --}}
                <div class="flex items-center lg:hidden">
                    <div class="w-16 h-16 flex items-center justify-center">
                        <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo">
                    </div>
                </div>

                {{-- Eyebrow --}}
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-1">Selamat Datang</h2>
                <p class="text-slate-500 mb-8">Masuk ke akun Anda untuk melanjutkan</p>

                {{-- Flash messages --}}
                @if (session('error'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    {{-- Email / NIM / NIP --}}
                    <div>
                        <label for="identifier" class="block text-sm font-semibold text-slate-700 mb-1.5">Email / NIM / NIP</label>
                        <input
                            type="text"
                            id="identifier"
                            name="identifier"
                            value="{{ old('identifier') }}"
                            placeholder="Masukkan email, NIM, atau NIP"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-primary-500 focus:ring-[3px] focus:ring-primary-100 transition-all"
                        >
                    </div>

                    {{-- Password --}}
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                        <div class="relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                name="password"
                                placeholder="Masukkan kata sandi"
                                required
                                autocomplete="current-password"
                                class="w-full h-11 px-4 pr-11 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:border-primary-500 focus:ring-[3px] focus:ring-primary-100 transition-all"
                            >
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                                :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                            >
                                <svg x-show="!showPassword" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-end mt-1.5">
                            <a href="{{ route('password.request') }}" class="text-xs text-primary-600 font-semibold hover:text-primary-700">
                                Lupa kata sandi?
                            </a>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full h-12 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary-200 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2 mt-2"
                    >
                        <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <div x-show="loading" x-cloak class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        <span x-text="loading ? 'Memproses...' : 'Masuk'"></span>
                    </button>
                </form>

                <p class="text-center text-xs text-slate-400 mt-8">&copy; 2026 CampusCare. All rights reserved.</p>
            </div>
        </div>
    </div>

</body>
</html>
