<div>
    <x-delete-modal />
    <x-hs-preline />

    <!-- Table Section -->
    {{-- <div class="max-w-[85rem] py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto"> --}}
    <div class="max-w-[85rem] pb-10 sm:px-6 lg:pb-14 mx-auto">
        <!-- Card -->
        <div>
            <!-- Header -->
            <div class="pb-4 grid gap-3 md:flex md:justify-between md:items-center ">
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
                        <button
                            class="cursor-pointer py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none"
                            wire:click="export" wire:loading.attr="disabled">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />

                            </svg>
                            Excel
                        </button>




                    </div>
                </div>
            </div>
        </div>

        <div
            class="p-4 relative mb-4 bg-white border border-gray-200 rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
            <!-- Header -->
            <div
                class="mb-2 pb-2 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                <div>
                    <p class="text-md font-semibold text-gray-800 dark:text-neutral-200">
                        Filter
                    </p>
                </div>
            </div>

            @include('livewire.admin.export-anggota.filter')

        </div>

        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div
                        class="py-2 bg-white border border-gray-200 rounded-xl shadow-2xs  dark:bg-neutral-900 dark:border-neutral-700">
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


                        <div class="">
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
                                                Status
                                            </span>
                                        </th>

                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @forelse ($anggotas as $anggota)
                                        <tr :key="{{ $anggota->id }}">
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
                                            
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ $anggota->status->name ?? '-' }} 
                                                        {{ $tanggalLahir = Carbon::parse($anggota->tgl_lahir);
                $usia = $tanggalLahir->diffInYears(Carbon::now()); }}
                                                        </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="h-px w-auto whitespace-nowrap" colspan="4">
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
