<div class="flex flex-col">
    <select
        wire:model="filters.{{ $filter->getKey() }}"
        class="w-full border-gray-300 focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50"
        data-flux-control
    >
        @foreach($filter->getOptions() as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
