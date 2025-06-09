<x-layout title="Login" :noSidebar="true">

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md" x-data="{ showPassword: false }">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block font-semibold mb-1" for="email">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block font-semibold mb-1" for="password">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-2 text-sm text-gray-600">
                        <span x-text="showPassword ? 'Hide' : 'Show'"></span>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
     <a href="/forgot-password" class="font-mono text-red-500">Lupa Password?</a>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Login
                </button>
            </div>
        </form>
    </div>
</x-layout>