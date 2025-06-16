<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>

    <div x-data="{ open: false }">
        <a href="#" @click="modalUser.openAdd()"
            class="text-4xl inline-block transform transition-transform duration-300 ease-in-out hover:rotate-45 hover:text-blue-500">
            +
        </a>

        {{-- FILTER & SEARCH (Mobile & Desktop) --}}
        <form method="GET" action="{{ route('accounts.index') }}"
            class="flex flex-col md:flex-row gap-4 items-center mb-4 mt-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email/NIK..."
                class="w-full md:w-1/3 px-4 py-2 border rounded-lg" autocomplete="off" />

            <select name="role" class="w-auto max-w-xs px-3 py-2 border rounded-lg">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>

            <select name="order" class="w-auto max-w-xs px-3 py-2 border rounded-lg">
                <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru
                </option>
                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full md:w-auto">
                Cari
            </button>
        </form>

        {{-- MOBILE VERSION --}}
        <div class="md:hidden space-y-4">
            @if($accountsMobile->count())
                @foreach ($accountsMobile as $account)
                    <div class="border rounded-lg p-4 bg-white shadow-sm">
                        <p><span class="font-semibold">Nama:</span> {{ $account->name }}</p>
                        <p><span class="font-semibold">Email:</span> {{ $account->email }}</p>
                        <p><span class="font-semibold">Tanggal Lahir:</span> {{ $account->date_of_birth }}</p>
                        <p><span class="font-semibold">Alamat:</span> {{ $account->address }}</p>
                        <p><span class="font-semibold">No KK:</span> {{ $account->no_kk }}</p>
                        <p><span class="font-semibold">NIK:</span> {{ $account->nik }}</p>
                        <p><span class="font-semibold">Role:</span> {{ $account->role }}</p>
                        <div class="mt-3 flex justify-end gap-2">
                            <a href="#" @click="modalUser.openEdit({
                                        id: '{{ $account->user_id }}',
                                        nama: '{{ $account->name }}',
                                        email: '{{ $account->email }}',
                                        date: '{{ $account->date_of_birth }}',
                                        address: '{{ $account->address }}',
                                        nik: '{{ $account->nik }}',
                                        no_kk: '{{ $account->no_kk }}',
                                        role: '{{ $account->role }}'
                                    })" class="text-blue-600 hover:underline">Ubah</a>
                            <a href="#" class="text-red-600 hover:underline">Hapus</a>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $accountsMobile->links() }}
                </div>
            @else
                <div class="text-center text-gray-500 py-8">Pengguna tidak ditemukan.</div>
            @endif
        </div>

        {{-- DESKTOP VERSION --}}
        <div class="hidden md:block overflow-x-auto border rounded-lg shadow-sm">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-left">No KK</th>
                        <th class="px-4 py-3 text-left">NIK</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 text-gray-700">
                    @if($accountsDesktop->count())
                        @foreach ($accountsDesktop as $account)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ ($accountsDesktop->currentPage() - 1) * $accountsDesktop->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-2">{{ $account->name }}</td>
                                <td class="px-4 py-2">{{ $account->email }}</td>
                                <td class="px-4 py-2">{{ $account->date_of_birth }}</td>
                                <td class="px-4 py-2">{{ $account->address }}</td>
                                <td class="px-4 py-2">{{ $account->no_kk }}</td>
                                <td class="px-4 py-2">{{ $account->nik }}</td>
                                <td class="px-4 py-2">{{ $account->role }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <a href="#" @click="modalUser.openEdit({
                                                id: '{{ $account->user_id }}',
                                                nama: '{{ $account->name }}',
                                                email: '{{ $account->email }}',
                                                password: '',
                                                date: '{{ $account->date_of_birth }}',
                                                address: '{{ $account->address }}',
                                                nik: '{{ $account->nik }}',
                                                no_kk: '{{ $account->no_kk }}',
                                                role: '{{ $account->role }}'
                                            })" class="text-blue-600 hover:underline mr-2">Ubah</a>
                                    {{-- Ganti form delete dengan button --}}
                                    <button onclick="deleteAccount('{{ $account->user_id }}')"
                                        class="text-red-500 hover:underline">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-8">Pengguna tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="mt-4">
                {{ $accountsDesktop->links() }}
            </div>
        </div>
    </div>
    <x-user-modal></x-user-modal>

    @push('scripts')
        <script>
            function deleteAccount(userId) {
                if (confirm('Apakah Anda yakin ingin menghapus akun ini?')) {
                    fetch(`/accounts/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Reload halaman atau update UI
                                window.location.reload();
                            } else {
                                alert('Gagal menghapus akun');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan');
                        });
                }
            }
        </script>
    @endpush
</x-layout>