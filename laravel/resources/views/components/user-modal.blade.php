<!-- Modal Component -->
<div x-data="userFormModal()" x-init="window.modalUser = $data" x-show="open" x-cloak x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <div @click.outside="close()"
        class="bg-white rounded-xl shadow-lg p-6 w-full max-w-3xl relative transition-all duration-300">

        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold" x-text="formMode === 'add' ? 'Tambah Akun' : 'Ubah Akun'"></h2>
            <button @click="close()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <!-- Modal Form Content -->
        <form class="space-y-6" @submit.prevent="submitForm">
            <input type="hidden" x-model="form.id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- <template x-for="field in fields" :key="field.id">
                    <div>
                        <label :for="field.id" class="block text-sm font-medium text-gray-700"
                            x-text="field.label"></label>
                        <template x-if="field.type === 'select'">
                            <select :id="field.id" x-model="form[field.model]"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                                <template x-for="option in field.options" :key="option">
                                    <option x-text="option"></option>
                                </template>
                            </select>
                        </template>
                        <template x-if="field.type !== 'select'">
                            <input :type="field.type" :id="field.id" x-model="form[field.model]"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        </template>
                    </div>
                </template> --}}
                <template x-for="field in fields" :key="field . id">
                    <!-- Sembunyikan password saat edit -->
                    <div x-show="!(formMode === 'edit' && field.model === 'password')">
                        <label :for="field . id" class="block text-sm font-medium text-gray-700"
                            x-text="field.label"></label>
                        <template x-if="field.type === 'select'">
                            <select :id="field . id" x-model="form[field.model]"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                                <template x-for="option in field.options" :key="option">
                                    <option x-text="option"></option>
                                </template>
                            </select>
                        </template>
                        <template x-if="field.type !== 'select'">
                            <input :type="field . type" :id="field . id" x-model="form[field.model]"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        </template>
                    </div>
                </template>

            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mr-2">Simpan</button>
                <button type="button" @click="close()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
            </div>
        </form>
    </div>
</div>