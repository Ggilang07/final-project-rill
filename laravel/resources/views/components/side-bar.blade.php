@php
    $templateActive = request()->is('letter-templates/*');
@endphp
<!-- Add x-cloak directive and preload class -->
<div x-data="{ open: false }" class="min-h-screen flex bg-gray-100">
    <!-- Sidebar - Add x-cloak and modify initial classes -->
    <div x-cloak :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
        class="fixed inset-y-0 left-0 bg-[#5180DB] shadow-md z-30 w-full md:w-64 flex flex-col overflow-hidden transform transition-transform duration-300 ease-in-out md:translate-x-0">
        <!-- Logo dan Header -->
        <div class="flex-shrink-0 cursor-pointer" onclick="window.location.href='/'">
            <div class="flex items-center justify-between px-3 py-2 border-b m-3 border-black">
                <div class="relative w-20 h-20 flex items-center justify-center">
                    <div class="absolute w-full h-full clip-hexagon border-4 bg-blue-900"></div>
                    <span class="iconify w-8 h-8 text-white z-10" data-icon="solar:letter-linear"></span>
                </div>
                <span class="font-quicksand font-bold text-3xl text-white">E-SURAT</span>
                <button @click="open = false" class="md:hidden text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto">
            <nav class="mt-6">
                <ul class="space-y-3">
                    <li>
                        <a href="/"
                            class="block px-6 py-2 border-b transition rounded-xl m-3 font-semibold
                                  {{ request()->is('/') ? 'border-white bg-white text-black' : 'border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/submissions"
                            class="block px-6 py-2 border-b transition rounded-xl m-3 font-semibold
                                  {{ request()->is('submissions') ? 'border-white bg-white text-black' : 'border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white' }}">
                            Pengajuan Surat
                        </a>
                    </li>
                    <li>
                        <a href="/accounts"
                            class="block px-6 py-2 border-b transition rounded-xl m-3 font-semibold
                                  {{ request()->is('accounts') ? 'border-white bg-white text-black' : 'border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white' }}">
                            Buat Akun
                        </a>
                    </li>
                    <li>
                        <a href="/profile"
                            class="block px-6 py-2 border-b transition rounded-xl m-3 font-semibold
                                  {{ request()->is('profile') ? 'border-white bg-white text-black' : 'border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white' }}">
                            Profile
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Logout Button (Always visible at bottom) -->
        <div class="flex-shrink-0 p-3">
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button"
                    onclick="confirmLogout(event)"
                    class="block px-6 py-2 border-b border-black bg-red-600 hover:bg-red-700 text-white font-semibold transition rounded-xl text-left">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Overlay - Add fade transition -->
    <div x-show="open" x-transition:enter="transition-opacity ease-in-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-black bg-opacity-30 z-20 md:hidden">
    </div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col md:ml-64">
        <!-- Topbar for mobile -->
        <header class="flex-shrink-0 flex items-center bg-white shadow-md px-4 py-3 md:hidden">
            <button @click="open = true" class="text-[#2950A4] mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="font-bold text-lg text-[#2950A4]">E-Surat</span>
        </header>

        <!-- Main scrollable area -->
        <main class="flex-1 overflow-y-auto p-6">
            <x-profile-header></x-profile-header>
            <h1 class="text-2xl font-bold mb-4">{{ $heading }}</h1>
            {{ $slot }}
        </main>

        <x-footer class="flex-shrink-0"></x-footer>
    </div>
</div>