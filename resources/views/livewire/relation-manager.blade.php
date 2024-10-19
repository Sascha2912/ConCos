<div>
    <!-- Dropdown für verfügbare Items -->
    <div class="edit-wrapper mb-8">
        <x-forms.field>
            <x-forms.label>{{ __('app.add_' . Str::singular($this->relatedModel)) }}:</x-forms.label>
            <select class="dropdown" wire:model="selectedItemId" wire:change="addRelation($event.target.value)"
                    wire:key="contract-select-{{ now() }}">
                <option value="default"></option>
                @foreach($availableItems as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </x-forms.field>
    </div>

    <!-- Liste der ausgewählten Items -->
    <div>
        <h2 class="mb-2 px-1 text-lg">{{ __('app.current_' . strtolower($relatedModel)) }}:</h2>
        <ul class="item-wrapper grid grid-cols-4 gap-2">
            @foreach($relatedItems as $item)
                <li class="relative item hover:bg-gray-200"
                    wire:key="{{ strtolower($relatedModel) . '-' . $item['id'] }}">
                    <a class="w-full"
                       href="{{ route(strtolower($relatedModel) . '.edit', $item['id']) }}">{{ $item['name'] }}</a>
                    <x-forms.delete-button
                            class="text-xl text-gray-600 hover:text-red-700 hover:font-bold absolute -top-1.5 right-1 h-full w-4"
                            type="button" wire:click="removeRelation({{ $item['id'] }})"/>
                </li>
            @endforeach
        </ul>
    </div>
</div>
