<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CampusCare') — CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        sidebar: '#0F172A',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans" x-data="{ sidebarOpen: false }">

    {{-- Overlay mobile --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-20 lg:hidden"
    ></div>

    {{-- SIDEBAR --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 h-full w-64 bg-slate-900 z-30 transition-transform duration-300 lg:translate-x-0 flex flex-col"
    >
        {{-- Logo --}}
        <div class="p-5 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center">
                    <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo">
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-tight">Campus<span class="text-blue-500">Care</span></p>
                    <p class="text-slate-400 text-xs">Layanan kampus, lebih mudah</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider px-3 mb-2">Menu</p>

            @php $role = auth()->user()->role; @endphp

            {{-- Mahasiswa & Dosen --}}
            @if(in_array($role, ['mahasiswa', 'dosen']))
                <x-nav-link route="mahasiswa.dashboard" icon="squares">Dashboard</x-nav-link>
                <x-nav-link route="mahasiswa.laporan.create" icon="plus-circle">Buat Laporan</x-nav-link>
                <x-nav-link route="mahasiswa.laporan.index" icon="document">Riwayat Laporan</x-nav-link>
                <x-nav-link route="mahasiswa.notifikasi.index" icon="bell" :badge="auth()->user()->notifikasis()->where('is_read', false)->count()">Notifikasi</x-nav-link>
                <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-2">Lainnya</p>
                <x-nav-link route="mahasiswa.panduan" icon="book">Panduan</x-nav-link>
                <x-nav-link route="mahasiswa.faq" icon="question">FAQ</x-nav-link>
            @endif

            {{-- Admin --}}
            @if(in_array($role, ['admin_prodi', 'admin_fakultas']))
                <x-nav-link route="admin.dashboard" icon="squares">Dashboard</x-nav-link>
                <x-nav-link route="admin.laporan.index" icon="document">Kelola Laporan</x-nav-link>
                <x-nav-link route="admin.notifikasi.index" icon="bell" :badge="auth()->user()->notifikasis()->where('is_read', false)->count()">Notifikasi</x-nav-link>
            @endif

            {{-- Staff --}}
            @if($role === 'staff')
                <x-nav-link route="staff.dashboard" icon="squares">Dashboard</x-nav-link>
                <x-nav-link route="staff.tugas.index" icon="clipboard">Tugas Saya</x-nav-link>
                <x-nav-link route="staff.notifikasi.index" icon="bell" :badge="auth()->user()->notifikasis()->where('is_read', false)->count()">Notifikasi</x-nav-link>
            @endif

            {{-- Super Admin --}}
            @if($role === 'super_admin')
                <x-nav-link route="superadmin.dashboard" icon="squares">Dashboard</x-nav-link>
                <x-nav-link route="superadmin.users.index" icon="users">Kelola User</x-nav-link>
                <x-nav-link route="superadmin.kategori.index" icon="tag">Kelola Kategori</x-nav-link>
                <x-nav-link route="superadmin.pengaturan.index" icon="cog">Pengaturan</x-nav-link>
            @endif
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN AREA --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-10 bg-white border-b border-slate-200 px-4 py-3 flex items-center gap-4">
            {{-- Hamburger --}}
            <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page title --}}
            <h1 class="font-semibold text-slate-700 text-sm lg:text-base flex-1">@yield('title', 'Dashboard')</h1>

            {{-- Notif icon --}}
            @if(auth()->user()->role !== 'super_admin')
            @php
                $notifRoute = match(auth()->user()->role) {
                    'mahasiswa', 'dosen'            => route('mahasiswa.notifikasi.index'),
                    'admin_prodi', 'admin_fakultas' => route('admin.notifikasi.index'),
                    'staff'                         => route('staff.notifikasi.index'),
                    default                         => '#',
                };
                $unread = auth()->user()->notifikasis()->where('is_read', false)->count();
            @endphp
            <a href="{{ $notifRoute }}" class="relative text-slate-500 hover:text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if($unread > 0)
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">{{ $unread }}</span>
                @endif
            </a>
            @endif

            {{-- User dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="font-medium text-xs leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-slate-400 text-xs capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-44 bg-white border border-slate-200 rounded-xl shadow-lg py-1 z-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-4 lg:p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>