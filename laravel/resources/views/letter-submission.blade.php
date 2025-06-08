<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>
            {{-- DESKTOP VERSION --}}
        <div class="hidden md:block overflow-x-auto border rounded-lg shadow-sm">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        {{-- <th class="px-4 py-3 text-left">No</th> --}}
                        <th class="px-4 py-3 text-left">Nomor Surat</th>
                        <th class="px-4 py-3 text-left">Pemohon</th>
                        <th class="px-4 py-3 text-left">Jenis Surat</th>
                        <th class="px-4 py-3 text-left">Alasan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 text-gray-700">
                    {{-- @if($accountsDesktop->count()) --}}
                        @foreach ($requests as $request)
                            <tr class="hover:bg-gray-50">
                                {{-- <td class="px-4 py-2">
                                    {{ ($requestsDesktop->currentPage() - 1) * $requestsDesktop->perPage() + $loop->iteration }}
                                </td> --}}
                                <td class="px-4 py-2">{{ $request->letter_number }}</td>
                                <td class="px-4 py-2">{{ $request->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $request->category }}</td>
                                <td class="px-4 py-2">{{ $request->reason }}</td>
                                <td class="px-4 py-2">
                                    @switch($request->status)
                                        @case('cancelled')
                                            <span class="text-gray-400 font-semibold">Dibatalkan</span>
                                            @break
                                        @case('approved')
                                            <span class="text-green-600 font-semibold">Disetujui</span>
                                            @break
                                        @case('rejected')
                                            <span class="text-red-600 font-semibold">Ditolak</span>
                                            @break
                                        @case('pending')
                                            <span class="text-yellow-500 font-semibold">Menunggu</span>
                                            @break
                                        @default
                                            <span class="text-gray-400">{{ ucfirst($request->status) }}</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    <a href="#"
                                    class="text-blue-600 hover:underline mr-2">Lihat</a>
                                    <a href="#"
                                    class="text-blue-600 hover:underline mr-2">Ubah Status</a>
                                </td>
                            </tr>
                        @endforeach
                    {{-- @else
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-8">Pengguna tidak ditemukan.</td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
            {{-- <div class="mt-4">
                {{ $accountsDesktop->links() }}
            </div> --}}
        </div>
</x-layout>
