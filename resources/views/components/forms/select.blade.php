<div x-data="{ open: false, selected: '{{ $selected }}' }" class="relative w-full">
    <!-- Label -->
    <x-forms.label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}:</x-forms.label>

    <!-- Custom Select Box -->
    <div @click="open = !open"
         class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm cursor-pointer">
        <span x-text="selected"></span>
        <!-- Arrow Icon -->
        <svg class="inline-block float-right w-5 h-5 text-gray-500"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false"
         class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
        <ul class="py-1 text-gray-700">
            @foreach ($options as $option)
                @if ($option !== $selected)
                    <li @click="selected = '{{ $option }}'; open = false;"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                        {{ $option }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <input type="hidden" name="{{ $name }}" :value="selected">
</div>
