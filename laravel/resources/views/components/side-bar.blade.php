<div x-data="{ open: false }" class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <div :class="open ? 'block' : 'hidden md:block'" class="fixed inset-y-0 left-0 bg-[#5180DB] shadow-md z-30 md:relative md:block transition-all w-full md:w-64">
        <div class="flex items-center justify-between px-6 py-4 border-b border-black">
            <span class="font-bold text-lg text-white">Logo custom | E-Surat</span>
            <button @click="open = false" class="md:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="mt-6 mb-6">
            <ul class="space-y-3">
                <li>
                    <a href="/"
                       class="block px-6 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white font-semibold transition rounded-xl m-3"
                       :class="{ 'bg-white text-black': $el === document.activeElement }"
                       @click="$el.blur()">
                        Dashboard
                    </a>
                </li>
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-between px-6 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white font-semibold focus:outline-none transition rounded-xl ml-3"
                        :class="{ 'bg-white text-blue-800': open }">
                        <span class="pr-12">Template Surat</span>
                        <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 ml-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <ul x-show="open" x-transition class="pl-8 space-y-2 mt-2">
                        <li>
                            <a href="/letter-templates/create" class="block px-4 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white transition rounded-xl m-3"
                               :class="{ 'bg-white text-black': $el === document.activeElement }"
                               @click="$el.blur()">Tambah Template</a>
                        </li>
                        <li>
                            <a href="/letter-templates/edit" class="block px-4 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white transition rounded-xl m-3"
                               :class="{ 'bg-white text-black': $el === document.activeElement }"
                               @click="$el.blur()">Ubah Template</a>
                        </li>
                        <li>
                            <a href="/letter-templates/delete" class="block px-4 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white transition rounded-xl m-3"
                               :class="{ 'bg-white text-black': $el === document.activeElement }"
                               @click="$el.blur()">Hapus Template</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/letter-submission"
                       class="block px-6 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white font-semibold transition rounded-xl m-3"
                       :class="{ 'bg-white text-black': $el === document.activeElement }"
                       @click="$el.blur()">
                        Pengajuan Surat
                    </a>
                </li>
                <li>
                    <a href="/accounts"
                       class="block px-6 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white font-semibold transition rounded-xl m-3"
                       :class="{ 'bg-white text-black': $el === document.activeElement }"
                       @click="$el.blur()">
                        Buat Akun
                    </a>
                </li>
                <li>
                    <a href="/profile"
                       class="block px-6 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white font-semibold transition rounded-xl m-3"
                       :class="{ 'bg-white text-black': $el === document.activeElement }"
                       @click="$el.blur()">
                        Profile
                    </a>
                </li>
                <li>
                    <a href="#"
                       class="block px-6 py-2 border-b border-black bg-[#2950A4] text-white hover:bg-[#355AA9] hover:text-white font-semibold transition rounded-xl m-3"
                       :class="{ 'bg-white text-black': $el === document.activeElement }"
                       @click="$el.blur()">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Overlay for mobile -->
    <div x-show="open" @click="open = false" class="fixed inset-0 bg-black bg-opacity-30 z-20 md:hidden"></div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Topbar for mobile -->
        <header class="flex items-center bg-white shadow-md px-4 py-3 md:hidden">
            <button @click="open = true" class="text-[#2950A4] mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="font-bold text-lg text-[#2950A4]">E-Surat</span>
        </header>
    </div>
</div>
