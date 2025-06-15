<div x-data="{ show: false }">
    <div x-show="show" x-transition x-cloak x-on:show-save-modal.window="show = true"
        x-on:close-save-modal.window="show = false" 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg w-full max-w-md shadow">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Konfirmasi Penyimpanan
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                Yakin ingin menyimpan data ini? Data akan dipindahkan dari data sementara.
            </p>
            <div class="flex justify-end gap-2">
                <button @click="show = false"
                    class="cursor-pointer px-4 py-2 bg-gray-200 dark:bg-neutral-600 text-gray-800 dark:text-white rounded">
                    Batal
                </button>
                <button wire:click="saveConfirmed" class="cursor-pointer px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>