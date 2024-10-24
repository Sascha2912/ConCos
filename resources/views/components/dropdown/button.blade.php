<button @click="open = !open; event.stopPropagation();" type="button"
        class="flex gap-2 content-center p-1 rounded-md sm:max-w-md leading-6">
    {{ $slot }}
    <div class="ms-1 block flex-1 border-0 bg-transparent py-0.5 px-0 text-white placeholder:text-gray-400 sm:text-sm sm:leading-6">
        <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"/>
        </svg>
    </div>
</button>