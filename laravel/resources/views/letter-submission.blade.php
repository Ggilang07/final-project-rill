<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>
    <div x-data="modalValidate()">

        {{-- FILTER & SEARCH (Mobile & Desktop) --}}
        <form method="GET" action="{{ route('submissions.index') }}"
            class="flex flex-col md:flex-row gap-4 items-center mb-4 mt-4">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nomor surat/pemohon/jenis/alasan..." class="w-full md:w-1/3 px-4 py-2 border rounded-lg"
                autocomplete="off" />

            <select name="category" class="w-auto max-w-xs px-3 py-2 border rounded-lg">
                <option value="">Semua Jenis Surat</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ str_replace('_', ' ', $cat) }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="w-auto max-w-xs px-3 py-2 border rounded-lg">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <select name="order" class="w-auto max-w-xs px-3 py-2 border rounded-lg">
                <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full md:w-auto">
                Cari
            </button>
        </form>

        {{-- MOBILE VERSION --}}
        <div class="md:hidden space-y-4">
            @if($requestsMobile->count())
                @foreach ($requestsMobile as $request)
                    <div class="border rounded-lg p-4 bg-white shadow-sm">
                        <p><span class="font-semibold">Nomor Surat:</span> {{ $request->letter_number }}</p>
                        <p><span class="font-semibold">Tanggal Surat:</span> {{ $request->letter_date }}</p>
                        <p><span class="font-semibold">Pemohon:</span> {{ $request->requestedBy->name }}</p>
                        <p><span class="font-semibold">Jenis Surat:</span> {{ str_replace('_', ' ', $request->category) }}</p>
                        <p><span class="font-semibold">Alasan:</span> {{ $request->reason }}</p>
                        <p><span class="font-semibold">Status:</span>
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
                        </p>
                        <div class="mt-3 flex justify-end gap-2">
                            <a href="#" @click.prevent="open({{ $request->request_id }})" class="text-blue-600 hover:underline">Ubah Status</a>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $requestsMobile->links() }}
                </div>
            @else
                <div class="text-center text-gray-500 py-8">Data surat tidak ditemukan.</div>
            @endif
        </div>

        {{-- DESKTOP VERSION --}}
        <div class="hidden md:block overflow-x-auto border rounded-lg shadow-sm">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nomor Surat</th>
                        <th class="px-4 py-3 text-left">Tanggal Surat</th>
                        <th class="px-4 py-3 text-left">Pemohon</th>
                        <th class="px-4 py-3 text-left">Jenis Surat</th>
                        <th class="px-4 py-3 text-left">Alasan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 text-gray-700">
                    @if($requestsDesktop->count())
                        @foreach ($requestsDesktop as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ ($requestsDesktop->currentPage() - 1) * $requestsDesktop->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-2">{{ $request->letter_number }}</td>
                                <td class="px-4 py-2">{{ $request->formatted_date }}</td>
                                <td class="px-4 py-2">{{ $request->requestedBy->name }}</td>
                                <td class="px-4 py-2">{{ str_replace('_', ' ', $request->category) }}</td>
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
                                    <a href="#" @click.prevent="open({{ $request->request_id }})"
                                        class="text-blue-600 hover:underline mr-2">
                                        Ubah Status
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8">Data surat tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="mt-4">
                {{ $requestsDesktop->links() }}
            </div>
        </div>

        <!-- Modal Komponen -->
         <div 
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50"
>

            <div class="bg-white rounded-2xl p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Validasi Surat</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Link Surat</label>
                    <input type="text" x-model="linkSurat" class="w-full border rounded px-3 py-2" placeholder="Masukkan link PDF">
                    <template x-if="error">
                        <p class="text-red-500 text-sm mt-1" x-text="error"></p>
                    </template>
                </div>

                <div class="flex justify-end space-x-2">
                    <button @click="submit('rejected')" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Ditolak</button>
                    <button @click="submit('approved')" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Diterima</button>
                    <button @click="close" class="px-4 py-2 rounded border">Batal</button>
                </div>
            </div>
        </div>
    </div>
<script>
        function modalValidate() {
    return {
        isOpen: false,
        requestId: null,
        linkSurat: '',
        error: '',

        open(id) {
            this.isOpen = true;
            this.requestId = id;
            this.linkSurat = '';
            this.error = '';
        },

        close() {
            this.isOpen = false;
            this.requestId = null;
            this.linkSurat = '';
            this.error = '';
        },

        async submit(status) {
            if (status === 'approved' && !this.linkSurat) {
                this.error = 'Link surat harus diisi terlebih dahulu.';
                return;
            }

            try {
                const response = await fetch('/validate-request', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        request_id: this.requestId,
                        status: status,
                        link_pdf: this.linkSurat
                    })
                });

                const result = await response.json();

                if (result.success) {
                    window.location.reload();
                } else {
                    this.error = result.message || 'Terjadi kesalahan.';
                }
            } catch (e) {
                this.error = 'Gagal mengirim data ke server.';
            }
        }
    };
}
        </script>

</x-layout>
