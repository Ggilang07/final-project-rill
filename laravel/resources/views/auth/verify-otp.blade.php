<x-layout title="Verify OTP" :noSidebar="true">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-200 py-8 px-4">
        <form method="POST" action="/verify-otp" class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8"
              x-data="otpInput()" @submit="setOtpValue">
            @csrf
            <div class="flex flex-col items-center mb-6">
                <svg class="w-14 h-14 text-blue-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                </svg>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Verifikasi OTP</h1>
                <p class="text-gray-500 text-center text-sm">Masukkan kode OTP yang telah dikirim ke email Anda.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-center gap-2 mb-6">
                <template x-for="(digit, index) in otp" :key="index">
                    <input
                        type="tel"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        class="w-12 h-14 text-center text-2xl border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all outline-none"
                        x-model="otp[index]"
                        @input="filterNumber($event, index); moveNext($event, index)"
                        @keydown.backspace="movePrev($event, index)"
                        name="otp[]"
                        autocomplete="off"
                        required
                    >
                </template>
            </div>
            <input type="hidden" name="otp" x-ref="otpHidden" />

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow transition">
                Verifikasi
            </button>
        </form>
    </div>

    <script>
        function otpInput() {
            return {
                otp: Array(6).fill(''),
                filterNumber(e, i) {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                    this.otp[i] = e.target.value;
                },
                moveNext(e, i) {
                    if (e.inputType === 'insertText' && e.target.value && i < this.otp.length - 1) {
                        e.target.form.querySelectorAll('input[type="tel"]')[i + 1].focus();
                    }
                },
                movePrev(e, i) {
                    if (e.key === 'Backspace' && !this.otp[i] && i > 0) {
                        e.target.form.querySelectorAll('input[type="tel"]')[i - 1].focus();
                    }
                },
                setOtpValue() {
                    this.$refs.otpHidden.value = this.otp.join('');
                }
            }
        }
    </script>
</x-layout>