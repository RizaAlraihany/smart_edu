<header class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-[#1E293B]">Dashboard</h1>
        <p class="text-xs text-[#64748B] mt-1 select-none">Selamat datang, Administrator</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <button aria-label="Notifications" class="relative text-gray-600 hover:text-gray-800 focus:outline-none">
                <i class="fas fa-bell text-lg"></i>
                <span
                    class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-semibold rounded-full w-5 h-5 flex items-center justify-center">
                    3
                </span>
            </button>

        </div>
        {{-- Menu Profil Pengguna --}}
        <div class="flex items-center gap-2 cursor-pointer select-none">
            {{-- Avatar dengan Inisial Nama --}}
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm">
                    {{-- Mengambil huruf pertama dari nama user dan mengubahnya menjadi kapital --}}
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                {{-- Nama dan Role/Email --}}
                <div class="text-right">
                    <div class="text-gray-900 font-semibold text-sm leading-tight">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-gray-500 text-xs leading-tight">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-red-600 focus:outline-none ml-2" title="Logout">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</header>
