<div>
    <x-hs-preline />

    <!-- Comment Form -->
    {{-- <div class="max-w-[85rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto"> --}}
    <div class="max-w-[85rem] py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="mx-auto ">
            <div>
                <!-- Header -->
                <div class="py-4 grid gap-3 md:flex md:justify-between md:items-center ">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                            Edit {{ strtolower($menuName) }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                            Lengkapi data {{ strtolower($menuName) }}
                        </p>
                    </div>

                    <div>
                        <div class="inline-flex gap-x-2">
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                href="{{ route('warga_keluarga.view') }}" wire:navigate> View 
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="p-4 relative bg-white border border-gray-200 rounded-xl md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
                <!-- Header -->
                <div
                    class="mb-2 pb-2 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                            Keterangan Tempat atau Keluarga
                        </h2>
                    </div>
                </div>
                <!-- End Header -->
                @include('livewire.admin.keluargas.form-keluarga')

            </div>
            <!-- End Card -->

            <div class="mt-4 p-4 relative bg-white border border-gray-200 rounded-xl md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
                <!-- Header -->
                <div class="mb-2 pb-2 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                            Anggota Keluarga
                        </h2>
                    </div>
                    <div>
                        <flux:modal.trigger name="create-anggota">
                            <flux:button variant="primary" class="cursor-pointer">
                                Tambah Data
                            </flux:button>
                        </flux:modal.trigger>

                        @livewire('admin.modal-anggotas.tambah-anggota', ['keluarga_id' => $keluarga_details->id], key('anggota-' . $keluarga_details->id))
                    </div>
                </div>
                <!-- End Header -->
                
                <div class="mb-4 sm:mb-8">
                    @livewire('admin.modal-anggotas.anggota-list', ['keluarga_id' => $keluarga_details->id], key('anggota-' . $keluarga_details->id))
                </div>
                
            </div>
            <!-- End Card -->


        

        </div>
    </div>
    <!-- End Comment Form -->
</div>

