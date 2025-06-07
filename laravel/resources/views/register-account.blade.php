<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- <x-slot:heading>{{ $heading }}</x-slot:heading> --}}
    <x-slot:heading>Akun Pengguna.blade</x-slot:heading>

    <div x-data="{ open: false }">
        <a href="#" @click="modalUser.openAdd()"
            class="text-4xl inline-block transform transition-transform duration-300 ease-in-out hover:rotate-45 hover:text-blue-500">
            +
        </a>

        <!-- MOBILE VERSION (List View) -->
        <div class="md:hidden space-y-4">
            @foreach ($accounts as $account)
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
                                   id: '{{ $account->id }}',
                                   nama: '{{ $account->name }}',
                                   email: '{{ $account->email }}',
                                   {{-- password: '', --}}
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
        </div>

        <!-- DESKTOP VERSION (Table View) -->
        <div class="hidden md:block overflow-x-auto border rounded-lg shadow-sm">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
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
                    @foreach ($accounts as $account)
{{-- {{ dd(get_class($account)) }} --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $account->name }}</td>
                            <td class="px-4 py-2">{{ $account->email }}</td>
                            <td class="px-4 py-2">{{ $account->date_of_birth }}</td>
                            <td class="px-4 py-2">{{ $account->address }}</td>
                            <td class="px-4 py-2">{{ $account->no_kk }}</td>
                            <td class="px-4 py-2">{{ $account->nik }}</td>
                            <td class="px-4 py-2">{{ $account->role }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <a href="#" @click="modalUser.openEdit({
                                               id: '{{ $account->id }}',
                                               nama: '{{ $account->name }}',
                                               email: '{{ $account->email }}',
                                               password: '',
                                               date: '{{ $account->date_of_birth }}',
                                               address: '{{ $account->address }}',
                                               nik: '{{ $account->nik }}',
                                               no_kk: '{{ $account->no_kk }}',
                                               role: '{{ $account->role }}'
                                           })" class="text-blue-600 hover:underline mr-2">Ubah</a>
                                <form action="{{ route('accounts.destroy', $account->user_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="text-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <x-user-modal></x-user-modal>
</x-layout>