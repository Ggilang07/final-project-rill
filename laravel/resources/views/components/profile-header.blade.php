@if (!request()->is('profile'))
    <div class="hidden md:flex items-center justify-end px-9 py-5 border-b border-gray-00">
        <div class="flex items-center space-x-4 cursor-pointer" onclick="window.location.href='/profile'">
            <div class="text-right mr-3">
                <div class="font-bold text-black leading-tight text-lg">
                    @auth
                        {{ auth()->user()->name }}
                    @endauth
                </div>
                <div class="text-base text-gray-600">
                    Human Resources Departement
                </div>
            </div>
            <div class="w-15 h-15 flex items-center justify-center border rounded-full overflow-hidden bg-white">
                @php
                    $profile = auth()->user()->p_profile ?? null;
                @endphp
                @if ($profile)
                    <img
                        src="{{ asset('images/profiles/' . $profile) }}"
                        alt="Profile"
                        class="w-10 h-10 object-cover rounded-full"
                    >
                @else
                    <img
                        src="{{ asset('images/profiles/icon-profile.jpg') }}"
                        alt="Profile"
                        class="w-10 h-10 object-cover rounded-full"
                    >
                @endif
            </div>
        </div>
    </div>
@endif