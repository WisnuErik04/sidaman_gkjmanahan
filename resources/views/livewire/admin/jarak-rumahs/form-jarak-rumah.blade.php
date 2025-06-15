<form wire:submit="save">

    <div class="mb-4 sm:mb-8 grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-6">            

        <div class="">
            <label for="hs-feedback-post-comment-name-1" class="block mb-2 text-sm font-medium dark:text-white">Nama <span class="text-red-500">*</span></label>
            <input type="text" wire:model="name"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 bg-gray-50 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                placeholder="Nama kepala keluarga">
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <flux:button
        class="cursor-pointer w-full py-3 px-4 mt-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border  
                    disabled:opacity-50 disabled:pointer-events-none"
        wire:click="save">
        Submit
    </flux:button>
    {{-- </div> --}}

</form>
