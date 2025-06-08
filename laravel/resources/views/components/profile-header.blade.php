@if (!request()->is('profile'))
    <div class="hidden md:flex items-center justify-end px-9 py-6 border-b">
        <div class="flex items-center space-x-4 cursor-pointer" onclick="window.location.href='/profile'">
            <div class="text-right">
                <div class="font-bold text-black leading-tight">
                    Muhammad Gilang Khaliq Nur Rahman
                </div>
                <div class="text-sm text-gray-600">
                    Human Resources Departement
                </div>
            </div>
            <div class="w-10 h-10 flex items-center justify-center border rounded-full">
                <div class="w-6 h-6 rounded-full bg-blue-300 relative">
                    <svg class="w-full h-full text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.2c-3.2 0-9.6 1.6-9.6 4.9V22h19.2v-2.9c0-3.3-6.4-4.9-9.6-4.9z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif