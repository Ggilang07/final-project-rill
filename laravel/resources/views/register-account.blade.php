<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>

    <div x-data="{ open: false }">
        <a href="#"  @click="open = true" class="text-4xl inline-block transform transition-transform duration-300 ease-in-out hover:rotate-45 hover:text-blue-500">
            +
        </a>


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Tanggal Lahir</th>
                        <th class="py-2 px-4 border-b">Alamat</th>
                        <th class="py-2 px-4 border-b">No KK</th>
                        <th class="py-2 px-4 border-b">NIK</th>
                        <th class="py-2 px-4 border-b">Role</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $account->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $account->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $account->date_of_birth }}</td>
                            <td class="py-2 px-4 border-b">{{ $account->address }}</td>
                            <td class="py-2 px-4 border-b">{{ $account->no_kk }}</td>
                            <td class="py-2 px-4 border-b">{{ $account->nik }}</td>
                            <td class="py-2 px-4 border-b">{{ $account->role }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="#" @click="open = true" class="text-blue-600 hover:underline mr-2">Ubah</a>
                                <a href="#" class="text-red-600 hover:underline">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.outside="open = false" class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md relative">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Buat Dinamis</h2>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                </div>

                <!-- Modal Form Content -->
                <form>
                    <input type="hidden" id="id" name="id" value="<?= $account['id']; ?>">
                    <!-- Input Nama -->
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" name="nama"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Input Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <!-- Input Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <!-- Input Tanggal Lahir -->
                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="date" name="date"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <!-- Input Alamat -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" id="address" name="address"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <!-- Input No KK -->
                    <div class="mb-4">
                        <label for="nik" class="block text-sm font-medium text-gray-700">Nomor Kartu Keluarga</label>
                        <input type="number" id="nik" name="nik"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                            required maxlength="16" />
                    </div>
                    <!-- Input No KK -->
                    <div class="mb-4">
                        <label for="no_kk" class="block text-sm font-medium text-gray-700">Nomor Induk Keluarga</label>
                        <input type="number" id="no_kk" name="no_kk"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                            required maxlength="16" />
                    </div>
                    <!-- Role -->
                    <div class="mb-4">
                        <label for="Role" class="block text-sm font-medium text-gray-700">Role Pengguna</label>
                        <select id="role" name="role"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="Karyawan">Karyawan</option>
                            <option value="Admin">Admin</option>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mr-2">Simpan</button>
                        <button type="button" @click="open = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>