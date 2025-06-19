<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>
    {{-- Success Notification - Use Laravel Session --}}
    @if(session()->has('success'))
        <div class="bg-green-50 text-green-800 rounded-lg p-4 flex items-center justify-between" x-data="{ show: true }"
            x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
    {{-- Error Notification --}}
    @if ($errors->any())
        <div class="bg-red-50 text-red-800 rounded-lg p-4 flex items-center justify-between mb-4"
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-2-7a1 1 0 112 0 1 1 0 01-2 0zm2-4a1 1 0 00-1 1v2a1 1 0 002 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-red-600 hover:text-red-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <div x-cloak x-data="{ editMode: false, changePassword: false, photoPreview: null }"
        class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow border-2">
        <!-- Foto Profil -->
        <div class="flex items-center space-x-6 mb-8">
            <div class="relative group">
                @php
                    $profile = auth()->user()->p_profile ?? null;
                    $defaultPhoto = asset('images/profiles/icon-profile.jpg');
                    $photoUrl = $profile ? asset('images/profiles/' . $profile) : $defaultPhoto;
                @endphp
                <img
                    :src="photoPreview || '{{ $photoUrl }}'"
                    class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg ring-4 ring-blue-200 transition-all duration-300 group-hover:scale-105"
                    alt="Foto Profil"
                >
                <label for="photo"
                    x-show="editMode"
                    class="absolute bottom-2 right-2 bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded-full cursor-pointer shadow-lg transition-all duration-200 opacity-90 group-hover:opacity-100"
                    style="display: none;"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l2 2m-2-2l-2-2m-6 6l-2 2m2-2l2 2" />
                    </svg>
                    Ganti
                </label>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Form Profil dengan style yang lebih sederhana -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6 space-y-6">
            @csrf
            @method('PUT')
            <input type="file" id="photo" name="photo" class="hidden"
                @change="photoPreview = URL.createObjectURL($event.target.files[0])">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                    <input name="name" type="text" class="w-full border px-3 py-2 rounded-lg transition-colors"
                        :class="editMode ? 'bg-white' : 'bg-gray-50'" :readonly="!editMode"
                        value="{{ auth()->user()->name }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input name="email" type="email" class="w-full border px-3 py-2 rounded-lg transition-colors"
                        :class="editMode ? 'bg-white' : 'bg-gray-50'" :readonly="!editMode"
                        value="{{ auth()->user()->email }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="text" class="w-full border px-3 py-2 rounded-lg bg-gray-100" readonly
                        value="{{ \Carbon\Carbon::parse(auth()->user()->date_of_birth)->translatedFormat('j F Y') }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" class="w-full border px-3 py-2 rounded-lg"
                        :readonly="!editMode">{{ auth()->user()->address }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Kartu Keluarga</label>
                    <input type="text" class="w-full border px-3 py-2 rounded-lg bg-gray-100" readonly
                        value="{{ auth()->user()->no_kk }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Keluarga</label>
                    <input type="text" class="w-full border px-3 py-2 rounded-lg bg-gray-100" readonly
                        value="{{ auth()->user()->nik }}">
                </div>
            </div>
            <!-- Tombol -->
            <div class="flex flex-wrap justify-between items-center mt-8 gap-2">
                <button type="button" x-show="!editMode" @click="editMode = true"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow">
                    Edit Profil
                </button>
                <div x-show="editMode" class="space-x-2">
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow">
                        Simpan
                    </button>
                    <button type="button" @click="editMode = false"
                        class="px-5 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors shadow">
                        Batal
                    </button>
                </div>
                <button type="button" @click="changePassword = true"
                    class="text-sm text-yellow-600 hover:text-yellow-800 transition-colors font-semibold">
                    Ganti Password
                </button>
            </div>
        </form>

        <!-- Modal Ganti Password -->
        <div x-show="changePassword" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display: none;">
            <div @click.away="changePassword = false"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative border-2 border-yellow-400 flex flex-col items-center">
                <button type="button" @click="changePassword = false"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <div class="flex flex-col items-center mb-4">
                    <div class="bg-yellow-100 rounded-full p-3 mb-2 shadow">
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.104 0 2-.896 2-2V7a2 2 0 10-4 0v2c0 1.104.896 2 2 2zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-yellow-700 mb-1">Ganti Password</h3>
                    <p class="text-gray-500 text-sm text-center">Pastikan password baru minimal 6 karakter dan konfirmasi sesuai.</p>
                </div>
                <form method="POST" action="{{ route('profile.change-password') }}"
                    x-data="{ showCurrent: false, showNew: false, showConfirm: false }" class="w-full space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <div class="relative">
                            <input :type="showCurrent ? 'text' : 'password'" name="current_password"
                                class="w-full border px-4 py-3 rounded-lg focus:ring focus:border-yellow-400 transition"
                                required autocomplete="current-password">
                            <button type="button" @click="showCurrent = !showCurrent"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-yellow-600">
                                <svg x-show="!showCurrent" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showCurrent" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.62 6.62A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.293 5.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <input :type="showNew ? 'text' : 'password'" name="new_password"
                                class="w-full border px-4 py-3 rounded-lg focus:ring focus:border-yellow-400 transition"
                                required autocomplete="new-password">
                            <button type="button" @click="showNew = !showNew"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-yellow-600">
                                <svg x-show="!showNew" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showNew" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.62 6.62A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.293 5.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation"
                                class="w-full border px-4 py-3 rounded-lg focus:ring focus:border-yellow-400 transition"
                                required autocomplete="new-password">
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-yellow-600">
                                <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.62 6.62A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.293 5.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="changePassword = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-semibold shadow">Simpan Password</button>
                    </div>
                </form>
            </div>
        </div>

        @if(auth()->user()->isUsingDefaultPassword())
            <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">
                <strong>Perhatian!</strong> Anda belum mengubah password default.<br>
                <span class="underline cursor-pointer" @click="changePassword = true">Ubah password sekarang</span>
            </div>
        @endif


    </div>

</x-layout>