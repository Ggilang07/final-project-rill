<x-layout title="Forgot Password" :noSidebar="true">
@if ($errors->has('email'))
    <p class="text-red-600 text-sm mb-2">{{ $errors->first('email') }}</p>
@endif

    <form method="POST" action="/forgot-password" class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
        @csrf
        <h1 class="text-xl font-bold mb-4">Lupa Password</h1>

        <input type="email" name="email" placeholder="Email" class="w-full border px-3 py-2 rounded mb-4" required>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
            Kirim OTP
        </button>
    </form>
</x-layout>