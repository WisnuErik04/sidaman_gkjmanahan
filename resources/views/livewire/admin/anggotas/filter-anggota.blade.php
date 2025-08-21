<div name="filter" class="max-w-96 sm:max-w-259">
    <div class="space-y-6">
        <div class="mt-8 mb-4 sm:mb-8 grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-6">

            <div class="">
                <label for="hs-feedback-post-comment-name-1" class="block mb-2 text-sm font-medium dark:text-white">Nama
                    Anggota</label>
                <input type="text"
                    class="py-1.5 sm:py-2 px-3 block w-full  border-gray-200 bg-gray-50 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="Cari nama anggota" wire:model.live="searchName">
            </div>

            <div class="">
                <label for="hs-feedback-post-comment-name-1"
                    class="block mb-2 text-sm font-medium dark:text-white">Keluarga</label>
                <input type="text"
                    class="py-1.5 sm:py-2 px-3 block w-full  border-gray-200 bg-gray-50 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="Cari keluarga" wire:model.live="searchKeluarga">
            </div>

            <div class="">
                <label for="hs-feedback-post-comment-name-1" class="block mb-2 text-sm font-medium dark:text-white">Blok
                    / Pepanthan</label>
                <select multiple="" wire:model.live="searchBlok"
                    data-hs-select='{        
                                                        "hasSearch": true,
                                                        "isSearchDirectMatch": false,
                                                        "searchPlaceholder": "Search...",
                                                        "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
                                                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-800",
                                                        "placeholder": "Pilih blok / pepanthan...",
                                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-3 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-50 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-800 dark:border-neutral-700",
                                                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-50 rounded-lg focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-400 dark:focus:bg-neutral-700",
                                                        "optionTemplate": "<div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div><div class=\"hs-selected:font-semibold text-sm text-gray-800 dark:text-neutral-200\" data-title></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
                                                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-400 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                                    }'
                    class="hidden">
                    {{-- <option value=""></option> --}}
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}">{{ $blok->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="">
                <label for="hs-feedback-post-comment-name-1"
                    class="block mb-2 text-sm font-medium dark:text-white">Nomor Induk Gereja</label>
                <input type="text"
                    class="py-1.5 sm:py-2 px-3 block w-full  border-gray-200 bg-gray-50 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="Cari nomor induk gereja" wire:model.live="searchNIG">
            </div>

            <div class="">
                <label for="hs-feedback-post-comment-name-1"
                    class="block mb-2 text-sm font-medium dark:text-white">Tanggal Lahir</label>
                <div class="w-full hs-dropdown [--auto-close:inside] [--placement:bottom-right] relative sm:inline-flex z-20">
                    <button id="hs-dropdown-filter" type="button"
                        class="cursor-pointer hs-dropdown-toggle py-2 w-full px-3 inline-flex items-center gap-x-2 text-sm rounded-lg border border-gray-200 bg-gray-50 text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        {{-- <button id="hs-dropdown-filter" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm rounded-lg border border-gray-200 bg-gray-50 text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"> --}}
                        Rentang Tanggal
                        <div class="absolute top-1/2 end-3 -translate-y-1/2">
                            <svg class="hs-dropdown-open:rotate-180 size-2.5 " width="16" height="16"
                                viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            </svg>
                        </div>
                    </button>

                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden bg-white border border-gray-200 shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-900 dark:border dark:border-neutral-700"
                        aria-labelledby="hs-dropdown-filter">
                        <div class="max-w-sm w-full flex gap-x-2">
                            <input type="date" wire:model.live="searchTgl_lahir_awal" id="hs-input-number-min-age"
                                class="py-1 px-2.5 block w-40 border-gray-200 rounded-md sm:text-[13px] bg-gray-50 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Min age" style="-moz-appearance: textfield;">
                            <input type="date" wire:model.live="searchTgl_lahir_akhir" id="hs-input-number-max-age"
                                class="py-1 px-2.5 block w-40 border-gray-200 rounded-md sm:text-[13px] bg-gray-50 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Max age" style="-moz-appearance: textfield;">
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
    {{-- <div class="flex gap-4">
        <flux:spacer />
        <flux:button type="submit" wire:click="resetFilter" class="cursor-pointer">Reset</flux:button>
        <flux:button type="submit" variant="primary" wire:click="cariFilter" class="cursor-pointer">Cari
        </flux:button>
    </div> --}}
</div>
