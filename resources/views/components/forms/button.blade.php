<button {{ $attributes->merge(['class' => 'rounded-md shadow-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600', 'type' => 'submit']) }}>
    {{ $slot }}
</button>
