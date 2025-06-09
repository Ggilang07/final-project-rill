<x-layout title="Reset Password" :noSidebar="true">
    <form method="POST" action="/reset-password" class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded"
        x-data="{ showPassword: false, showConfirmPassword: false }">
        @csrf
        <h1 class="text-xl font-bold mb-4">Reset Password</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="relative mb-4">
            <input :type="showPassword ? 'text' : 'password'" 
                   name="password" 
                   placeholder="Password Baru"
                   class="w-full border px-3 py-2 rounded @error('password') border-red-500 @enderror" 
                   required>
            <button type="button" @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-600">
                <span x-text="showPassword ? 'Hide' : 'Show'"></span>
            </button>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="relative mb-4">
            <input :type="showConfirmPassword ? 'text' : 'password'" 
                   name="password_confirmation"
                   placeholder="Konfirmasi Password" 
                   class="w-full border px-3 py-2 rounded @error('password_confirmation') border-red-500 @enderror" 
                   required>
            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-600">
                <span x-text="showConfirmPassword ? 'Hide' : 'Show'"></span>
            </button>
            @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded w-full">
            Ubah Password
        </button>
    </form>
</x-layout>