 

<div class="overflow-hidden">
    @livewire('admin.modal-anggotas.edit-anggota')
    @livewire('admin.modal-anggotas.pindah-anggota')
    @livewire('admin.modal-anggotas.wafat-anggota')
    <x-delete-modal />
    <x-reset-modal />

    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 divide-y divide-gray-200 dark:bg-neutral-800 dark:divide-neutral-700">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Nama
                    </span>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Jenis Kelamin
                    </span>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Nomor Induk Gereja
                    </span>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Hubungan Keluarga
                    </span>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Tanggal Lahir
                    </span>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Status
                    </span>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                        Action
                    </span>
                </th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            @forelse ($anggotas as $anggota)
                <tr :key="{{ $anggota->id }}">
                    <td class="h-px w-auto whitespace-nowrap">
                        <div class="px-6 py-2">
                            <span class="font-semibold text-sm text-gray-800 dark:text-neutral-200">{{ $anggota->name }}
                            </span>
                        </div>
                    </td>
                    <td class="h-px w-auto whitespace-nowrap">
                        <div class="px-6 py-2">
                            <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $anggota->jns_kelamin }}</span>
                        </div>
                    </td>
                    <td class="h-px w-auto whitespace-nowrap">
                        <div class="px-6 py-2">
                            <span
                                class="text-sm text-gray-800 dark:text-neutral-200">{{ $anggota->nomor_induk_gereja }}</span>
                        </div>
                    </td>
                    <td class="h-px w-auto whitespace-nowrap">
                        <div class="px-6 py-2">
                            <span
                                class="text-sm text-gray-800 dark:text-neutral-200">{{ $anggota->hubunganKeluarga->name }}</span>
                        </div>
                    </td>
                    <td class="h-px w-auto whitespace-nowrap">
                        <div class="px-6 py-2">
                            <span class="text-sm text-gray-800 dark:text-neutral-200">{{ \Carbon\Carbon::parse($anggota->tgl_lahir)->translatedFormat('d F Y') }}</span>
                        </div>
                    </td>
                    <td class="h-px w-auto whitespace-nowrap">
                        <div class="px-6 py-2">
                            @if ($anggota->is_wafat == '1')
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-green-200">
                                    Wafat
                                </span>    
                            @else
                                <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                    Aktif
                                </span>                    
                            @endif
                        </div>
                    </td>

                    <td class="size-px whitespace-nowrap">
                        <div class="px-6 py-2">
                            <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                <button id="hs-table-dropdown-1" type="button"
                                    class="hs-dropdown-toggle py-1.5 px-2 inline-flex cursor-pointer justify-center items-center gap-2 rounded-lg text-gray-700 align-middle disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:text-neutral-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="1" />
                                        <circle cx="19" cy="12" r="1" />
                                        <circle cx="5" cy="12" r="1" />
                                    </svg>
                                </button>
                                <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-20 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700"
                                    role="menu" aria-orientation="vertical" aria-labelledby="hs-table-dropdown-1">
                                    <div class="py-2 first:pt-0 last:pb-0">
                                        <span
                                            class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                            Actions
                                        </span>
                                        <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                            wire:click="edit({{ $anggota->id }}, {{ $anggota->keluarga_id }})">
                                            Edit
                                        </a>
                                        <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                            wire:click="pindahKepala({{ $anggota->id }}, {{ $anggota->keluarga_id }})">
                                            Pindah Kepala
                                        </a>
                                        <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                            wire:click="wafat({{ $anggota->id }}, {{ $anggota->keluarga_id }})">
                                            Wafat
                                        </a>
                                        <a class="cursor-pointer flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                            wire:click="resetPassword({{ $anggota->id }})">
                                            Reset Password
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
                    <td class="h-px w-auto whitespace-nowrap" colspan="7">
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




