<x-layout title="OTP" :noSidebar="true">
    <div class="p-6 bg-white rounded-xl shadow-md max-w-md mx-auto">
        <p class="text-gray-700 text-base mb-2">Berikut adalah kode OTP untuk reset password Anda:</p>
        <h2 class="text-3xl font-bold tracking-widest text-blue-600 my-4 text-center">{{ $otp }}</h2>
        <p class="text-gray-700 text-base mb-2">Silakan masukkan kode ini pada halaman verifikasi OTP.</p>
        <p class="text-gray-500 text-sm mb-2">Jika Anda tidak melakukan permintaan ini, abaikan email ini.</p>
        <p class="text-gray-700 text-base mb-2">Kode berlaku selama <span class="font-semibold">5 menit</span>.</p>
        <p class="text-red-600 font-semibold text-sm mt-4">
            <b>Jaga kerahasiaan kode OTP Anda.</b> Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengaku
            dari admin.
        </p>
    </div>
</x-layout>