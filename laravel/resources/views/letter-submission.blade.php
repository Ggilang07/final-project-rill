<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>
    <div x-data="modalValidate()">

        {{-- FILTER & SEARCH (Mobile & Desktop) --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('submissions.index') }}"
                class="flex flex-col md:flex-row gap-4 items-center">
                
                <!-- Search Input -->
                <div class="relative w-full md:w-1/3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari nomor surat/pemohon/jenis/alasan..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200"
                        autocomplete="off"
                    />
                </div>

                <!-- Filter Group -->
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <!-- Category Filter -->
                    <div class="relative">
                        <select name="category" class="appearance-none w-full md:w-48 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200 cursor-pointer bg-white">
                            <option value="">Semua Jenis Surat</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $cat) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="relative">
                        <select name="status" class="appearance-none w-full md:w-44 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200 cursor-pointer bg-white">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Order Filter -->
                    <div class="relative">
                        <select name="order" class="appearance-none w-full md:w-36 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200 cursor-pointer bg-white">
                            <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Search Button -->
                <button type="submit"
                    class="w-full md:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg inline-flex items-center justify-center gap-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Cari</span>
                </button>
            </form>
        </div>

        {{-- MOBILE VERSION --}}
        <div class="md:hidden space-y-4">
            @if($requestsMobile->count())
                @foreach ($requestsMobile as $request)
                    <div class="border rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="space-y-3">
                            {{-- Header with Number and Date --}}
                            <div class="flex justify-between items-start">
                                <div class="space-y-1">
                                    <h3 class="font-semibold text-gray-900">{{ $request->letter_number }}</h3>
                                    <p class="text-sm text-gray-500">{{ $request->formatted_date }}</p>
                                </div>
                                {{-- Status Badge --}}
                                @switch($request->status)
                                    @case('cancelled')
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-700 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-gray-400 animate-pulse"></span>
                                            Dibatalkan
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-700 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                            Disetujui
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-700 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                                            Ditolak
                                        </span>
                                        @break
                                    @case('pending')
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                                            Menunggu
                                        </span>
                                        @break
                                @endswitch
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-gray-100"></div>

                            {{-- Content --}}
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div class="text-gray-500">Pemohon</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ $request->requestedBy->name }}</div>
                                
                                <div class="text-gray-500">Jenis Surat</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ str_replace('_', ' ', $request->category) }}</div>
                                
                                <div class="text-gray-500">Alasan</div>
                                <div class="col-span-2 font-medium text-gray-900">{{ $request->reason }}</div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex justify-end gap-2 pt-3">
                                <button 
                                    @click.prevent="openDetail({{ $request->request_id }})"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 rounded-lg hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Detail
                                </button>

                                <button 
                                    @click.prevent="open({{ $request->request_id }}, {{ $request->is_validated ? 'true' : 'false' }})"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium transition-all duration-300"
                                    :class="{{ $request->is_validated }} ? 
                                        'bg-gray-100 text-gray-400 cursor-not-allowed' : 
                                        'text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2'"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                                        stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                {{ $request->is_validated ? 'Sudah Divalidasi' : 'Ubah Status' }}
                            </button>
                            </div>
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
                        {{-- <th class="px-4 py-3 text-left">Alasan</th> --}}
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center"></th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 text-gray-700">
                    @if($requestsDesktop->count())
                        @foreach ($requestsDesktop as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ ($requestsDesktop->currentPage() - 1) * $requestsDesktop->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4">{{ $request->letter_number }}</td>
                                <td class="px-4 py-4">{{ $request->formatted_date }}</td>
                                <td class="px-4 py-4">{{ $request->requestedBy->name }}</td>
                                <td class="px-4 py-4">{{ str_replace('_', ' ', $request->category) }}</td>
                                {{-- <td class="px-4 py-4">{{ $request->reason }}</td> --}}
                                <td class="px-4 py-4">
                                    @switch($request->status)
                                        @case('cancelled')
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                                Dibatalkan
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                                Disetujui
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                                Ditolak
                                            </span>
                                            @break
                                        @case('pending')
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                                                Menunggu
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="#"
                                           @click.prevent="openDetail({{ $request->request_id }})"
                                           class="group relative inline-flex items-center gap-2 px-4 py-2 border border-yellow-500 bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition-all duration-300 shadow-md hover:shadow-lg">
                                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-yellow-600 to-yellow-500 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                                 class="w-5 h-5 relative z-10 transform group-hover:scale-110 transition-transform duration-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="relative z-10 font-medium">Detail</span>
                                        </a>

                                        <a href="#" 
                                           @click.prevent="open({{ $request->request_id }}, {{ $request->is_validated ? 'true' : 'false' }})"
                                           class="group relative inline-flex items-center gap-2 px-4 py-2 border transition-all duration-300"
                                           :class="{{ $request->is_validated }} ? 
                                                'border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed pointer-events-none' : 
                                                'border-green-500 bg-gradient-to-r from-green-500 to-green-400 text-white hover:from-green-600 hover:to-green-500 shadow-md hover:shadow-lg'"
                                           {{ $request->is_validated ? 'disabled' : '' }}
                                        >
                                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-green-600 to-green-500 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                                x-show="!{{ $request->is_validated }}"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                                 class="w-5 h-5 relative z-10 transform group-hover:scale-110 transition-transform duration-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            <span class="relative z-10 font-medium">Ubah Status</span>
                                        </a>
                                    </div>
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

        <!-- Validation Modal -->
        <div 
    x-show="isOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div 
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
        >
            <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"></div>
        </div>

        <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button @click="close" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Validasi Surat</h2>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Surat</label>
                        <input 
                            type="text" 
                            x-model="linkSurat" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Masukkan link PDF surat"
                        >
                        <template x-if="error">
                            <p class="mt-2 text-sm text-red-600" x-text="error"></p>
                        </template>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button 
                            @click="submit('rejected')"
                            class="inline-flex justify-center px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                        >
                            Ditolak
                        </button>
                        <button 
                            @click="submit('approved')"
                            class="inline-flex justify-center px-4 py-2.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
                        >
                            Diterima
                        </button>
                        <button 
                            @click="close"
                            class="inline-flex justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                        >
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Detail Modal -->
        <div 
    x-show="isDetailOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div 
            x-show="isDetailOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
        >
            <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"></div>
        </div>

        <div class="relative inline-block w-full max-w-2xl p-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button @click="closeDetail" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail</h2>

            <div class="space-y-6">
                <template x-if="detailData">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="divide-y divide-gray-100">
                            <!-- ... existing detail rows with enhanced styling ... -->
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Nomor Surat</span>
                                <span class="col-span-2" x-text="detailData.letter_number"></span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Tanggal Surat</span>
                                <span class="col-span-2" x-text="detailData.letter_date"></span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Tanggal Dibuat</span>
                                <span class="col-span-2" x-text="detailData.created_at"></span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Jenis Surat</span>
                                <span class="col-span-2" x-text="detailData.category"></span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Alasan</span>
                                <span class="col-span-2" x-text="detailData.reason"></span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Status</span>
                                <span class="col-span-2">
                                    <span 
                                        :class="{
                                            'inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium': true,
                                            'bg-yellow-100 text-yellow-700': detailData.status === 'pending',
                                            'bg-green-100 text-green-700': detailData.status === 'approved',
                                            'bg-red-100 text-red-700': detailData.status === 'rejected',
                                            'bg-gray-100 text-gray-700': detailData.status === 'cancelled'
                                        }"
                                    >
                                        <span 
                                            class="w-2 h-2 rounded-full"
                                            :class="{
                                                'bg-yellow-400': detailData.status === 'pending',
                                                'bg-green-400': detailData.status === 'approved',
                                                'bg-red-400': detailData.status === 'rejected',
                                                'bg-gray-400': detailData.status === 'cancelled'
                                            }"
                                        ></span>
                                        <span x-text="formatStatus(detailData.status)"></span>
                                    </span>
                                </span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Pemohon</span>
                                <span class="col-span-2" x-text="detailData.requested_by"></span>
                            </div>
                            <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-700">Divalidasi Oleh</span>
                                <span class="col-span-2" x-text="detailData.validated_by"></span>
                            </div>
                            <template x-if="detailData.status === 'approved'">
                                <div class="grid grid-cols-3 p-4 hover:bg-gray-50 transition-colors">
                                    <span class="font-medium text-gray-700">Link Surat</span>
                                    <a :href="detailData.link_pdf" 
                                       target="_blank"
                                       class="col-span-2 text-blue-600 hover:underline"
                                       x-text="detailData.link_pdf"></a>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-8 flex justify-end">
                <button 
                    @click="closeDetail"
                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
    </div>
</x-layout>
