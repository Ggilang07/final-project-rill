<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>

    <div x-data class="p-2 space-y-3 bg-gray-50">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 cursor-pointer" onclick="window.location.href='/submissions'">
            <div class="bg-white p-5 rounded-2xl shadow-md relative overflow-hidden">
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21,2H3A2,2 0 0,0 1,4V20A2,2 0 0,0 3,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2M21,20H3V4H21V20M5,13H19V11H5V13M5,17H19V15H5V17M5,9H19V7H5V9Z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-blue-600">{{ $hariIni }}</h2>
                    <p class="text-gray-600 mt-1">Pengajuan Hari Ini</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md relative overflow-hidden">
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21,2H3A2,2 0 0,0 1,4V20A2,2 0 0,0 3,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2M21,20H3V4H21V20M5,13H19V11H5V13M5,17H19V15H5V17M5,9H19V7H5V9Z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-green-600">{{ $approved }}</h2>
                    <p class="text-gray-600 mt-1">Surat Disetujui</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md relative overflow-hidden">
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21,2H3A2,2 0 0,0 1,4V20A2,2 0 0,0 3,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2M21,20H3V4H21V20M5,13H19V11H5V13M5,17H19V15H5V17M5,9H19V7H5V9Z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-yellow-500">{{ $pending }}</h2>
                    <p class="text-gray-600 mt-1">Menunggu Persetujuan</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md relative overflow-hidden">
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21,2H3A2,2 0 0,0 1,4V20A2,2 0 0,0 3,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2M21,20H3V4H21V20M5,13H19V11H5V13M5,17H19V15H5V17M5,9H19V7H5V9Z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-gray-400">{{ $cancelled }}</h2>
                    <p class="text-gray-600 mt-1">Surat Dibatalkan</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md relative overflow-hidden">
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21,2H3A2,2 0 0,0 1,4V20A2,2 0 0,0 3,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2M21,20H3V4H21V20M5,13H19V11H5V13M5,17H19V15H5V17M5,9H19V7H5V9Z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-red-500">{{ $rejected }}</h2>
                    <p class="text-gray-600 mt-1">Surat Ditolak</p>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white mt-6 p-6 rounded-2xl shadow-md relative overflow-hidden">
            <div class="absolute inset-0 opacity-5 bg-gradient-to-br from-blue-100 to-transparent"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Statistik Surat Bulan Ini</h3>
                <canvas id="suratChart" class="w-full max-w-xl h-64 mx-auto"></canvas>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            window.chartData = [{{ $total ?? 0 }}, {{ $approved ?? 0 }}, {{ $pending ?? 0 }}, {{ $rejected ?? 0 }}, {{ $cancelled ?? 0 }}];
        </script>
    @endpush

</x-layout>