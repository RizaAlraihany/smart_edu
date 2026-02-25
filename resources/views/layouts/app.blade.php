<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Smart Education') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-white border-r border-gray-200">
                <!-- Logo -->
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-blue-600">
                    <div class="flex items-center">
                        <div class="bg-white p-2 rounded-lg mr-3">
                            <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                        </div>
                        <h1 class="text-white font-bold text-lg">EduSmart</h1>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex-1 flex flex-col overflow-y-auto pt-5 pb-4">
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>

                        @if (auth()->user()->isAdmin())
                            <!-- Data Siswa -->
                            <a href="{{ route('siswa.index') }}"
                                class="sidebar-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                                <i class="fas fa-user-graduate mr-3"></i>
                                Data Siswa
                            </a>

                            <!-- Data Guru -->
                            <a href="{{ route('guru.index') }}"
                                class="sidebar-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                                <i class="fas fa-chalkboard-teacher mr-3"></i>
                                Data Guru
                            </a>

                            <!-- Data Kelas -->
                            <a href="{{ route('kelas.index') }}"
                                class="sidebar-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                                <i class="fas fa-door-open mr-3"></i>
                                Data Kelas
                            </a>

                            <!-- Mata Pelajaran -->
                            <a href="{{ route('mata-pelajaran.index') }}"
                                class="sidebar-link {{ request()->routeIs('mata-pelajaran.*') ? 'active' : '' }}">
                                <i class="fas fa-book mr-3"></i>
                                Mata Pelajaran
                            </a>
                        @endif

                        @if (auth()->user()->isAdmin() || auth()->user()->isGuru())
                            <!-- Jadwal -->
                            <a href="{{ route('jadwal.index') }}"
                                class="sidebar-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                Jadwal
                            </a>

                            <!-- Absensi -->
                            <a href="{{ route('absensi.index') }}"
                                class="sidebar-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-check mr-3"></i>
                                Absensi
                            </a>

                            <!-- Nilai -->
                            <a href="{{ route('nilai.index') }}"
                                class="sidebar-link {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                                <i class="fas fa-chart-line mr-3"></i>
                                Nilai
                            </a>
                        @endif

                        @if (auth()->user()->isAdmin())
                            <!-- Pembayaran -->
                            <a href="{{ route('pembayaran.index') }}"
                                class="sidebar-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave mr-3"></i>
                                Pembayaran
                            </a>
                        @endif

                        @if (auth()->user()->isAdmin() || auth()->user()->isGuru())
                            <!-- Pengumuman -->
                            <a href="{{ route('pengumuman.index') }}"
                                class="sidebar-link {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                                <i class="fas fa-bullhorn mr-3"></i>
                                Pengumuman
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="md:pl-64 flex flex-col w-0 flex-1">
            <!-- Top header -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <!-- Mobile menu button -->
                <button type="button"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                    onclick="toggleMobileSidebar()">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars text-lg"></i>
                </button>

                <div class="flex-1 px-4 flex justify-between items-center">
                    <div>
                        @isset($header)
                            <h1 class="text-xl font-semibold text-gray-900">{{ $header }}</h1>
                        @endisset
                    </div>

                    <!-- User menu -->
                    <div class="relative" x-data="{ open: false }">
                        <div>
                            <button type="button"
                                class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                id="user-menu-button" @click="open = !open">
                                <span class="sr-only">Open user menu</span>
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </button>
                        </div>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            @click.away="open = false">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-cog mr-2"></i>Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Success Messages -->
                        @if (session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"
                                    onclick="this.parentElement.style.display='none'">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if (session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"
                                    onclick="this.parentElement.style.display='none'">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="fixed inset-0 flex z-40 md:hidden hidden" id="mobile-sidebar">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="toggleMobileSidebar()"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button"
                    class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    onclick="toggleMobileSidebar()">
                    <span class="sr-only">Close sidebar</span>
                    <i class="fas fa-times text-white text-lg"></i>
                </button>
            </div>
            <!-- Copy sidebar content here for mobile -->
        </div>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>

</html>
