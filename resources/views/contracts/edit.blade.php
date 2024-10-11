<x-app-layout>

    <x-slot:header>
        {{ __('app.edit_contract') }}
    </x-slot:header>

    <form method="POST" action="{{ route('contracts.update', $contract->id) }}">
        @csrf
        @method('PUT')

        <label>{{ __('app.name') }}:</label>
        <input type="text" name="name" value="{{ $contract->name }}">

        <label>{{ __('app.hours') }}:</label>
        <input type="number" name="hours" value="{{ $contract->hours }}">

        <label>{{ __('app.monthly_costs') }}:</label>
        <input type="number" name="monthly_costs" step="0.01" value="{{ $contract->monthly_costs }}">

        <label>{{ __('app.flatrate') }}:</label>
        <input type="checkbox" name="flatrate" @if($contract->flatrate) checked @endif>

        <label>{{ __('app.start_date') }}:</label>
        <input type="date" name="start_date" value="{{ $contract->start_date }}" required>

        <label>{{ __('app.end_date') }}:</label>
        <input type="date" name="end_date" value="{{ $contract->end_date }}">

        <label>{{ __('app.services') }}:</label>
        <select name="service_id[]" multiple>
            @foreach($services as $service)
                <option value="{{ $service->id }}" @if($contract->services->contains($service->id))
                    selected
                        @endif>{{ $service->name }}</option>
            @endforeach
        </select>

        <button type="submit">{{ __('app.save') }}</button>
    </form>
</x-app-layout>