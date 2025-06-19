<!-- Modal Component -->
<div x-data="userFormModal()" x-init="window.modalUser = $data" x-show="open" x-cloak x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <div @click.outside="close()"
        class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl relative border-2 border-blue-200 transition-all duration-300">

        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 rounded-full p-2">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c1.104 0 2-.896 2-2V7a2 2 0 10-4 0v2c0 1.104.896 2 2 2zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-blue-700" x-text="formMode === 'add' ? 'Tambah Akun' : 'Ubah Akun'"></h2>
            </div>
            <button @click="close()" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <!-- Modal Form Content -->
        <form action="{{ route('accounts.store') }}" method="post" class="space-y-8" @submit.prevent="submitForm">
            <input type="hidden" x-model="form.id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <template x-for="field in fields" :key="field.id">
                    <div x-show="!(formMode === 'edit' && field.model === 'password')">
                        <label :for="field.id" class="block text-sm font-semibold text-gray-700 mb-1"
                            x-text="field.label"></label>
                        <template x-if="field.type === 'select'">
                            <select :id="field.id" x-model="form[field.model]"
                                class="mt-1 block w-full border border-blue-200 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 cursor-pointer bg-blue-50">
                                <template x-for="option in field.options" :key="option.value">
                                    <option :value="option.value" x-text="option.label"></option>
                                </template>
                            </select>
                        </template>
                        <template x-if="field.type !== 'select'">
                            <input :type="field.type" :id="field.id" x-model="form[field.model]"
                                class="mt-1 block w-full border border-blue-200 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-blue-50 placeholder-gray-400"
                                :placeholder="field.label">
                        </template>
                    </div>
                </template>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end mt-8 gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition-all duration-200">Simpan</button>
                <button type="button" @click="close()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold transition-all duration-200">Batal</button>
            </div>
        </form>
    </div>
</div>