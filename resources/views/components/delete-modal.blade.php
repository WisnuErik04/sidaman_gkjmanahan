<div x-data="{ show: false }">
    <div x-show="show" x-transition x-cloak x-on:show-delete-modal.window="show = true"
        x-on:close-delete-modal.window="show = false" 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg w-full max-w-md shadow">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Konfirmasi Penghapusan
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-2">
                <button @click="show = false"
                    class="cursor-pointer px-4 py-2 bg-gray-200 dark:bg-neutral-600 text-gray-800 dark:text-white rounded">
                    Batal
                </button>
                <button wire:click="deleteConfirmed" class="cursor-pointer px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>