<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>

    <div x-data class="p-2 space-y-3">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 cursor-pointer" onclick="window.location.href='/letter-submissions'">
            <div class="bg-white p-5 rounded-2xl shadow-md">
                <h2 class="text-3xl font-bold text-blue-600">{{ $hariIni }}</h2>
                <p class="text-gray-600 mt-1">Pengajuan Hari Ini</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md">
                <h2 class="text-3xl font-bold text-green-600">{{ $approved }}</h2>
                <p class="text-gray-600 mt-1">Surat Disetujui</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md">
                <h2 class="text-3xl font-bold text-yellow-500">{{ $pending }}</h2>
                <p class="text-gray-600 mt-1">Menunggu Persetujuan</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md">
                <h2 class="text-3xl font-bold text-gray-400">{{ $cancelled }}</h2>
                <p class="text-gray-600 mt-1">Surat Dibatalkan</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md">
                <h2 class="text-3xl font-bold text-red-500">{{ $rejected }}</h2>
                <p class="text-gray-600 mt-1">Surat Ditolak</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white mt-6 p-6 rounded-2xl shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Statistik Surat Bulan Ini</h3>
            <canvas id="suratChart" class="w-full max-w-xl h-64 mx-auto"></canvas>
        </div>
    </div>


    @push('scripts')
        <script>
            window.chartData = [{{ $total ?? 0 }}, {{ $approved ?? 0 }}, {{ $pending ?? 0 }}, {{ $rejected ?? 0 }}, {{ $cancelled ?? 0 }}];
        </script>
    @endpush

</x-layout>