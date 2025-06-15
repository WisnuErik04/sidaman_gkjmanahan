<div class="">
    <x-hs-preline />

    <flux:modal name="wafat-anggota" class="md:w-96">
        <div class="space-y-6">
            <div class="pb-4 border-b border-gray-200 dark:border-neutral-700">
                <flux:heading size="lg">Tambah {{ strtolower($menuName) }}</flux:heading>
                <flux:text class="mt-2">Lengkapi data {{ strtolower($menuName) }}</flux:text>
            </div>

            <form wire:submit="saveAnggota">
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-1 gap-4 lg:gap-6">
                

                <div>
                    <label for="hs-feedback-post-comment-name-1"
                        class="block mb-2 text-sm font-medium dark:text-white">Tanggal wafat</label>
                    <input type="date"
                        class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Tanggal wafat" wire:model="tgl_wafat">
                    @error('tgl_wafat')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="saveAnggota" class="cursor-pointer">Simpan
                </flux:button>
            </div>
            </form>
        </div>
    </flux:modal>
</div>

