@props(['name'])

@error($name)
<p class="text-xs text-red-500 font-semibold mt-1 block w-full text-right">{{ $message }}</p>
@enderror