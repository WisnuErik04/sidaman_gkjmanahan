{{-- <div class="flex rounded-md shadow-sm">
    <input
        wire:model.debounce="columnSearch.{{ $field }}"
        placeholder="Search {{ ucfirst($field) }}"
        type="text"
        class="block w-full border-gray-300 rounded-md shadow-sm transition duration-150 ease-in-out sm:text-sm sm:leading-5 dark:bg-gray-800 dark:text-white dark:border-gray-600 @if (isset($columnSearch[$field]) && strlen($columnSearch[$field])) rounded-none rounded-l-md focus:ring-0 focus:border-gray-300 @else focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md @endif"
    />
    @if (isset($columnSearch[$field]) && strlen($columnSearch[$field]))
        <span wire:click="$set('columnSearch.{{ $field }}', null)" class="inline-flex items-center px-3 text-gray-500 border border-l-0 border-gray-300 cursor-pointer bg-gray-50 rounded-r-md sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </span>
    @endif
</div> --}}

<div class="flex rounded-md shadow-sm">
    <input
        wire:model.debounce.500ms="columnSearch.{{ $field }}"
        type="text"
        placeholder="Search {{ ucfirst($field) }}"
        class="w-full border-gray-300 focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50"
        data-flux-control
    />
</div>
