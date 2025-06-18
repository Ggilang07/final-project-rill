<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>

    <div x-data="{ open: false }" class="space-y-6">
        {{-- Add Account Button --}}
        <div class="flex justify-between items-center">
            <button @click="modalUser.openAdd()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Akun
            </button>
        </div>

        {{-- Search & Filter Section --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form method="GET" action="{{ route('accounts.index') }}"
                class="flex flex-col md:flex-row gap-4 items-center">

                {{-- Search Input --}}
                <div class="relative w-full md:w-1/3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200"
                        placeholder="Cari nama/email/NIK..." autocomplete="off">
                </div>

                {{-- Role Filter --}}
                <div class="relative">
                    <select name="role"
                        class="appearance-none w-full md:w-44 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Order Filter --}}
                <div class="relative">
                    <select name="order"
                        class="appearance-none w-full md:w-44 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200">
                        <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Search Button --}}
                <button type="submit"
                    class="w-full md:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg inline-flex items-center justify-center gap-2 transition-colors duration-200 shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Cari</span>
                </button>
            </form>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-4">
            @if($accountsMobile->count())
                @foreach ($accountsMobile as $account)
                    <div class="border rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="space-y-3">
                            {{-- Header with Name and Role Badge --}}
                            <div class="flex justify-between items-start">
                                <div class="space-y-1">
                                    <h3 class="font-semibold text-gray-900">{{ $account->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $account->email }}</p>
                                </div>
                                <span
                                    class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $account->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    <span
                                        class="w-2 h-2 rounded-full {{ $account->role === 'admin' ? 'bg-purple-400' : 'bg-blue-400' }} animate-pulse"></span>
                                    {{ ucfirst($account->role) }}
                                </span>
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-gray-100"></div>

                            {{-- Content Grid --}}
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div class="text-gray-500">Tanggal Lahir</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ $account->date_of_birth }}</div>

                                <div class="text-gray-500">Alamat</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ $account->address }}</div>

                                <div class="text-gray-500">No KK</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ $account->no_kk }}</div>

                                <div class="text-gray-500">NIK</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ $account->nik }}</div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex justify-end gap-2 pt-3 border-t">
                                <button @click="modalUser.openEdit({
                                                                id: '{{ $account->user_id }}',
                                                                nama: '{{ $account->name }}',
                                                                email: '{{ $account->email }}',
                                                                date: '{{ $account->date_of_birth }}',
                                                                address: '{{ $account->address }}',
                                                                nik: '{{ $account->nik }}',
                                                                no_kk: '{{ $account->no_kk }}',
                                                                role: '{{ $account->role }}'
                                                            })"
                                    class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-4 h-4 mr-1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Ubah
                                </button>
                                <button onclick="deleteAccount('{{ $account->user_id }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-4 h-4 mr-1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
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

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
            <table class="min-w-full table-fixed bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        <th class="px-2 py-3 text-left w-10">No</th>
                        <th class="px-2 py-3 text-left w-32">Nama</th>
                        <th class="px-2 py-3 text-left w-40">Email</th>
                        <th class="px-2 py-3 text-left w-28">Tanggal Lahir</th>
                        <th class="px-2 py-3 text-left w-48">Alamat</th>
                        <th class="px-2 py-3 text-left w-32">No KK</th>
                        <th class="px-2 py-3 text-left w-32">NIK</th>
                        <th class="px-2 py-3 text-left w-24">Role</th>
                        <th class="px-2 py-3 text-left w-32"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($accountsDesktop->count())
                        @foreach ($accountsDesktop as $account)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ($accountsDesktop->currentPage() - 1) * $accountsDesktop->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap max-w-[8rem] truncate">
                                    <div class="text-sm font-medium text-gray-900">{{ $account->name }}</div>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap max-w-[12rem] truncate text-sm text-gray-500">{{ $account->email }}</td>
                                <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">{{ $account->date_of_birth }}</td>
                                <td class="px-2 py-4 whitespace-nowrap max-w-[14rem] truncate text-sm text-gray-500">{{ $account->address }}</td>
                                <td class="px-2 py-4 whitespace-nowrap max-w-[10rem] truncate text-sm text-gray-500">{{ $account->no_kk }}</td>
                                <td class="px-2 py-4 whitespace-nowrap max-w-[10rem] truncate text-sm text-gray-500">{{ $account->nik }}</td>
                                <td class="px-2 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $account->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($account->role) }}
                                    </span>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button @click="modalUser.openEdit({
                                                                                id: '{{ $account->user_id }}',
                                                                                nama: '{{ $account->name }}',
                                                                                email: '{{ $account->email }}',
                                                                                date: '{{ $account->date_of_birth }}',
                                                                                address: '{{ $account->address }}',
                                                                                nik: '{{ $account->nik }}',
                                                                                no_kk: '{{ $account->no_kk }}',
                                                                                role: '{{ $account->role }}'
                                                                            })"
                                        class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Ubah
                                    </button>
                                    <button onclick="deleteAccount('{{ $account->user_id }}')"
                                        class="inline-flex items-center px-3 py-1.5 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="px-3 py-10 text-center text-gray-500">Pengguna tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="px-4 py-4 border-t">
                {{ $accountsDesktop->links() }}
            </div>
        </div>
    </div>
    <x-user-modal></x-user-modal>
</x-layout>