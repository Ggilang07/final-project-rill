<x-layout title="Verify Otp" :noSidebar="true">
    <form method="POST" action="/verify-otp" class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
        @csrf
        <h1 class="text-xl font-bold mb-4">Verifikasi OTP</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <input type="text" name="otp" placeholder="Masukkan OTP" class="w-full border px-3 py-2 rounded mb-4" required>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
            Verifikasi
        </button>
    </form>
</x-layout>