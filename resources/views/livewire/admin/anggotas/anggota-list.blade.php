<div>
    <x-delete-modal />

    <!-- Table Section -->
    <div class="max-w-[85rem] py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Card -->
        <div>
            <!-- Header -->
            <div class="py-4 grid gap-3 md:flex md:justify-between md:items-center ">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ $menuName }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        Informasi data {{ strtolower($menuName) }}
                    </p>
                </div>

                <div>
                    <div class="inline-flex gap-x-2">
                        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none"
                            href="{{ route('anggota.import') }}" wire:navigate>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            Import
                        </a>

                        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            href="{{ route('anggota.create') }}" wire:navigate>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            Create
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div
                        class="py-2 bg-white border border-gray-200 rounded-xl shadow-2xs overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                        <!-- Table -->
                        <div class="py-3 px-4">
                            <div class="flex items-center justify-between">
                                {{-- Search --}}


                                {{-- filter n Paginate --}}
                                <div class="flex items-center gap-3">


                                    <!-- Dropdown PerPage -->
                                    <div class="hs-dropdown relative">
                                        <button id="hs-pagination-dropdown" type="button"
                                            class="py-1.5 px-2 inline-flex items-center gap-x-1 text-sm rounded-lg border border-gray-200 text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                            {{ $perPage }} page
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </button>

                                        <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-48 hidden z-50 transition-[margin,opacity] opacity-0 duration-300 mb-2 bg-white shadow-md rounded-lg p-1 space-y-0.5 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700"
                                            role="menu" aria-orientation="vertical"
                                            aria-labelledby="hs-pagination-dropdown">
                                            <button wire:click="setPerPage(5)" type="button"
                                                class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300">
                                                5 page
                                            </button>
                                            <button wire:click="setPerPage(10)" type="button"
                                                class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300">
                                                10 page
                                            </button>
                                            <button wire:click="setPerPage(25)" type="button"
                                                class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300">
                                                25 page
                                            </button>
                                            <button wire:click="setPerPage(50)" type="button"
                                                class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300">
                                                50 page
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                <thead
                                    class="bg-gray-50 divide-y divide-gray-200 dark:bg-neutral-800 dark:divide-neutral-700">
                                    <tr>
                                        <th scope="col" wire:click="sortBy('name')"
                                            class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                                            <span
                                                class="hover:text-gray-500 dark:hover:text-neutral-500 focus:outline-hidden focus:text-gray-500 dark:focus:text-neutral-500 cursor-pointer 
                                                            text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Nama
                                                @if ($sortField1 == 'name')
                                                    @if ($sortDirection1 == 'asc')
                                                        &nbsp;↑
                                                    @else
                                                        &nbsp;↓
                                                    @endif
                                                @endif
                                            </span>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Keluarga
                                            </span>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                No. Induk Gereja
                                            </span>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Tanggal Lahir
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Action
                                            </span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    <tr>
                                        <td class="h-px w-auto px-6 py-2 whitespace-nowrap">
                                            <div class="relative max-w-xs">
                                                <input type="text"
                                                    class="py-1.5 sm:py-2 px-3 ps-9 block w-full  border-gray-200 bg-gray-50 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                    placeholder="Cari nama anggota" wire:model.live="searchName">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                                    <svg class="size-4 text-gray-400 dark:text-neutral-500"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                        <path d="m21 21-4.3-4.3"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h-px w-auto px-6 py-2 whitespace-nowrap">
                                            <div class="relative max-w-xs">
                                                <input type="text"
                                                    class="py-1.5 sm:py-2 px-3 ps-9 block w-full  border-gray-200 bg-gray-50 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                    placeholder="Cari keluarga" wire:model.live="searchKeluarga">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                                    <svg class="size-4 text-gray-400 dark:text-neutral-500"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                        <path d="m21 21-4.3-4.3"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h-px w-auto px-6 py-2 whitespace-nowrap">
                                            <div class="relative max-w-xs">
                                                <input type="text"
                                                    class="py-1.5 sm:py-2 px-3 ps-9 block w-full  border-gray-200 bg-gray-50 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                    placeholder="Cari nomor induk gereja" wire:model.live="searchNIG">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                                    <svg class="size-4 text-gray-400 dark:text-neutral-500"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                        <path d="m21 21-4.3-4.3"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h-px w-auto px-6 py-2 whitespace-nowrap">
                                            <div class="relative max-w-xs">

                                                <div
                                                    class="hs-dropdown [--auto-close:inside] [--placement:bottom-right] relative sm:inline-flex z-20">
                                                    <button id="hs-dropdown-filter" type="button"
                                                        class="cursor-pointer hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm rounded-lg border border-gray-200 bg-gray-50 text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                                        {{-- <button id="hs-dropdown-filter" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm rounded-lg border border-gray-200 bg-gray-50 text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"> --}}
                                                        Rentang Tanggal
                                                        <svg class="hs-dropdown-open:rotate-180 size-2.5"
                                                            width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round"></path>
                                                        </svg>
                                                    </button>

                                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden bg-white border border-gray-200 shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-900 dark:border dark:border-neutral-700"
                                                        aria-labelledby="hs-dropdown-filter">
                                                        <div class="max-w-sm w-full flex gap-x-2">
                                                            <input type="date"
                                                                wire:model.live="searchTgl_lahir_awal"
                                                                id="hs-input-number-min-age"
                                                                class="py-1 px-2.5 block w-40 border-gray-200 rounded-md sm:text-[13px] bg-gray-50 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                                placeholder="Min age"
                                                                style="-moz-appearance: textfield;">
                                                            <input type="date"
                                                                wire:model.live="searchTgl_lahir_akhir"
                                                                id="hs-input-number-max-age"
                                                                class="py-1 px-2.5 block w-40 border-gray-200 rounded-md sm:text-[13px] bg-gray-50 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                                placeholder="Max age"
                                                                style="-moz-appearance: textfield;">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @forelse ($anggotas as $anggota)
                                        <tr :key="{{ $anggota->id }}"
                                            class=" {{ $anggota->is_wafat == '1' ? 'bg-red-50 dark:bg-red-100' : '' }}">
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span
                                                        class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $anggota->name }}</span>
                                                    <span
                                                        class="block text-sm text-gray-500 dark:text-neutral-500">{{ $anggota->hubunganKeluarga->name }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span
                                                        class="block text-sm text-gray-800 dark:text-neutral-200">{{ $anggota->keluarga->name }}</span>
                                                    <span
                                                        class="block text-sm text-gray-500 dark:text-neutral-500">{{ $anggota->keluarga->blok->name }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ $anggota->nomor_induk_gereja }} </span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ \Carbon\Carbon::parse($anggota->tgl_lahir)->translatedFormat('d F Y') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="h-px w-52">

                                                <div class="px-6 py-2">
                                                    <div
                                                        class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                                        <button id="hs-table-dropdown-1" type="button"
                                                            class="hs-dropdown-toggle py-1.5 px-2 inline-flex cursor-pointer justify-center items-center gap-2 rounded-lg text-gray-700 align-middle disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:text-neutral-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                                                            aria-haspopup="menu" aria-expanded="false"
                                                            aria-label="Dropdown">
                                                            <svg class="shrink-0 size-4"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="1" />
                                                                <circle cx="19" cy="12" r="1" />
                                                                <circle cx="5" cy="12" r="1" />
                                                            </svg>
                                                        </button>
                                                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-20 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700"
                                                            role="menu" aria-orientation="vertical"
                                                            aria-labelledby="hs-table-dropdown-1">
                                                            <div class="py-2 first:pt-0 last:pb-0">
                                                                <span
                                                                    class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                                                    Actions
                                                                </span>
                                                                <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                                                    href="{{ route('anggota.view', ['id' => $anggota->id]) }}"
                                                                    wire:navigate>
                                                                    Lihat
                                                                </a>
                                                                <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                                                    href="{{ route('anggota.edit', ['id' => $anggota->id]) }}"
                                                                    {{-- wire:navigate --}}
                                                                    >
                                                                    Edit
                                                                </a>
                                                            </div>
                                                            <div class="py-2 first:pt-0 last:pb-0">
                                                                <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-red-500 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                                                    wire:click="confirmDelete({{ $anggota->id }})">
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="h-px w-auto whitespace-nowrap" colspan="5">
                                                <div class="px-6 py-2 text-center">
                                                    <span class="text-sm text-gray-800 dark:text-neutral-200">
                                                        Data kosong</span>
                                                    {{-- <span class="text-xs text-gray-500 dark:text-neutral-500">(23.16%)</span> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="px-6 py-4  border-t border-gray-200 dark:border-neutral-700">
                            {{ $anggotas->links() }}

                        </div>
                        <!-- End Footer -->


                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->
</div>
