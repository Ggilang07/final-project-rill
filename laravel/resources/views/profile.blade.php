<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>

    <div x-cloak x-data="{ editMode: false, changePassword: false, photoPreview: null }"
        class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow border-2 transition-colors duration-500"
        :class="editMode ? 'animate-border-rgb' : ''">
        <!-- Foto Profil -->
        <div class="flex items-center space-x-4 mb-6">
            <div class="relative">
                @php
                    $profile = auth()->user()->p_profile ?? null;
                @endphp
                <img
                    :src="photoPreview || '{{ $profile ? asset('images/profiles/' . $profile) : asset('images/profiles/icon-profile.jpg') }}'"
                    class="w-24 h-24 rounded-full object-cover border"
                >
            <label for="photo"
                x-show="editMode"
                class="absolute bottom-0 right-0 bg-blue-600 text-white text-xs px-2 py-1 rounded cursor-pointer">
                Ubah
            </label>


            </div>
            <div>
                <h2 class="text-xl font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Form Profil -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <input type="file" id="photo" name="photo"
                class="hidden"
                @change="photoPreview = URL.createObjectURL($event.target.files[0])">

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input name="name" type="text" class="w-full border px-3 py-2 rounded" :readonly="!editMode"
                    value="{{ auth()->user()->name }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" type="email" class="w-full border px-3 py-2 rounded" :readonly="!editMode"
                    value="{{ auth()->user()->email }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" readonly
                    value="{{ \Carbon\Carbon::parse(auth()->user()->date_of_birth)->translatedFormat('j F Y') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="address" class="w-full border px-3 py-2 rounded"
                    :readonly="!editMode">{{ auth()->user()->address }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Kartu Keluarga</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" readonly
                    value="{{ auth()->user()->no_kk }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Induk Keluarga</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" readonly
                    value="{{ auth()->user()->nik }}">
            </div>

            <!-- Tombol Edit dan Simpan -->
            <div class="flex justify-between items-center mt-6">
                <button type="button" x-show="!editMode" @click="editMode = true"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit Profil</button>
                <div x-show="editMode" class="space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                    <button type="button" @click="editMode = false"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
                </div>
                <!-- Tombol Ganti Password -->
                <button type="button" @click="changePassword = true"
                    class="text-sm text-blue-600 underline">Ganti Password</button>
            </div>
        </form>

        <!-- Modal Ganti Password -->
        <div
            x-show="changePassword"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
            style="display: none;"
        >
            <div @click.away="changePassword = false"
                class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
                <button type="button" @click="changePassword = false"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                <h3 class="text-lg font-semibold mb-4 text-center">Ganti Password</h3>
                <form method="POST" action="{{ route('profile.change-password') }}"
                    x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <input :type="showCurrent ? 'text' : 'password'" name="current_password"
                            class="w-full border px-3 py-2 rounded focus:ring focus:border-blue-400" required>
                        <button type="button" @click="showCurrent = !showCurrent"
                            class="absolute right-3 top-8 text-xs text-gray-600">
                            <span x-text="showCurrent ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>

                    <div class="mb-4 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input :type="showNew ? 'text' : 'password'" name="new_password"
                            class="w-full border px-3 py-2 rounded focus:ring focus:border-blue-400" required>
                        <button type="button" @click="showNew = !showNew"
                            class="absolute right-3 top-8 text-xs text-gray-600">
                            <span x-text="showNew ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>

                    <div class="mb-6 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation"
                            class="w-full border px-3 py-2 rounded focus:ring focus:border-blue-400" required>
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute right-3 top-8 text-xs text-gray-600">
                            <span x-text="showConfirm ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="changePassword = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Simpan Password</button>
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

        @if ($errors->any())
            <div class="mb-4">
                @foreach ($errors->all() as $error)
                    <div class="text-red-600 text-sm">{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </div>

</x-layout>