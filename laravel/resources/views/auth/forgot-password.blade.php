<x-layout title="Forgot Password" :noSidebar="true">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-200 py-8 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <div class="flex flex-col items-center mb-6">
                <svg class="w-16 h-16 text-blue-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                </svg>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Lupa Password?</h1>
                <p class="text-gray-500 text-center text-sm">Masukkan email Anda untuk menerima kode OTP reset password.</p>
            </div>
            @if ($errors->has('email'))
                <p class="text-red-600 text-sm mb-4 text-center">{{ $errors->first('email') }}</p>
            @endif
            <form method="POST" action="/forgot-password" class="space-y-5">
                @csrf
                <div class="group">
                    <label class="block font-semibold mb-2 text-gray-700 group-focus-within:text-blue-600 transition-colors" for="email">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" required
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300"
                            placeholder="Masukkan email Anda"
                            autofocus>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow transition">
                    Kirim OTP
                </button>
            </form>
            <div class="mt-6 text-center">
                <a href="/login" class="text-blue-600 hover:underline text-sm">Kembali ke Login</a>
            </div>
        </div>
    </div>
</x-layout>