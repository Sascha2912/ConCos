@props([
    'title' => '',
    'createUrl' => '#',
    'createLabel' => 'Add New',
    'headers' => [],
    'rows' => []
])

@php
    $colCount = count($headers);
@endphp

<div class="container">
    <h1 class="text-2xl font-bold mb-4">{{ $title }}</h1>

    <x-action-button href="{{ $createUrl }}" class="create">{{ $createLabel }}</x-action-button>

    <div class="min-w-full bg-white dark:bg-gray-300 text-black dark:text-white mt-4 rounded">

        <!-- Header Row -->
        <div class="bg-gray-300 grid rounded-t text-black justify-items-center"
             style="grid-template-columns: repeat({{ $colCount }}, 1fr);">
            @foreach($headers as $header)
                <div class="py-3 px-4 rounded-t bg-gray-300 uppercase font-semibold text-sm">
                    {{ $header }}
                </div>
            @endforeach
        </div>

        <!-- Data Rows -->
        <div class=" border">
            @foreach($rows as $row)
                <div class="bg-gray-200 dark:bg-gray-600 mb-0.5 hover:bg-gray-100 dark:hover:text-black grid justify-items-center"
                     style="grid-template-columns: repeat({{ $colCount }}, 1fr);">
                    @foreach($row['columns'] as $column)
                        <div class=" p-0 bg-transparent">
                            <a href="{{ $row['editUrl'] }}"
                               class="block h-full w-full py-6 px-4 bg-transparent">
                                {{ $column }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
</div>