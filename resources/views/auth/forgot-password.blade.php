<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi — CampusCare</title>
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
                        Reset Kata<br>Sandi Anda
                    </h1>
                    <p class="mt-6 text-[15px] leading-relaxed text-slate-600 max-w-md">
                        Masukkan email yang terdaftar dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.
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
                    <h2 class="text-2xl font-bold text-slate-900">Lupa Kata Sandi?</h2>
                    <p class="mt-1 text-sm text-slate-500">Masukkan email Anda untuk menerima link reset</p>
                </div>

                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input
                                type="email" id="email" name="email"
                                value="{{ old('email') }}"
                                placeholder="email@kampus.ac.id"
                                required autofocus
                                class="block w-full min-h-[44px] rounded-[10px] border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            >
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full min-h-[52px] items-center justify-center gap-2 rounded-[10px] bg-primary text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Kirim Link Reset
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke halaman login
                    </a>
                </div>

                <p class="mt-8 text-center text-xs text-blue-300">&copy; 2026 CampusCare. All rights reserved.</p>
            </div>
        </div>
    </div>

</body>
</html>
