<div class="">
    <x-hs-preline />

    {{-- <flux:modal name="create-anggota" class="md:max-w-[85rem] dark:bg-neutral-900! dark:border-neutral-700!"> --}}
    <flux:modal name="create-anggota" class="md:max-w-[85rem]">
        <div class="space-y-6">
            <div class="pb-4 border-b border-gray-200 dark:border-neutral-700">
                <flux:heading size="lg">Tambah {{ strtolower($menuName) }}</flux:heading>
                <flux:text class="mt-2">Lengkapi data {{ strtolower($menuName) }}</flux:text>
            </div>

            @include('livewire.admin.modal-anggotas.form-anggota')

        </div>
    </flux:modal>
</div>
