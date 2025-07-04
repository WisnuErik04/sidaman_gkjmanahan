<div class="">
    <x-hs-preline />

    <flux:modal name="pindah-anggota" class="md:w-96">
        <div class="space-y-6">
            <div class="pb-4 border-b border-gray-200 dark:border-neutral-700">
                <flux:heading size="lg">Tambah {{ strtolower($menuName) }}</flux:heading>
                <flux:text class="mt-2">Lengkapi data {{ strtolower($menuName) }}</flux:text>
            </div>

            <form wire:submit="saveAnggota">
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-1 gap-4 lg:gap-6">
                

                <div>
                    <label for="hs-feedback-post-comment-name-1"
                        class="block mb-2 text-sm font-medium dark:text-white">keluarga</label>

                    <select wire:model="keluarga_id"
                        data-hs-select='{        
                            "hasSearch": true,
                            "searchLimit": 5,
                            "searchPlaceholder": "Search...",
                            "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
                            "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                            "placeholder": "Pilih Hubungan keluarga...",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                            "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                            "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                        class="">
                        <option value=""></option>
                        @foreach ($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}">{{ $keluarga->name }} | {{ $keluarga->blok->name }}</option>
                        @endforeach
                    </select>
                    @error('keluarga_id')
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

