<x-app-layout>

    <x-slot:header>
        Edit Contract
    </x-slot:header>

    <form method="POST" action="{{ route('contracts.update', $contract->id) }}">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $contract->name }}">

        <label>Hours:</label>
        <input type="number" name="hours" value="{{ $contract->hours }}">

        <label>Monthly costs:</label>
        <input type="number" name="monthly_costs" step="0.01" value="{{ $contract->monthly_costs }}">

        <label>Flatrate:</label>
        <input type="checkbox" name="flatrate" @if($contract->flatrate) checked @endif>

        <label>Start date:</label>
        <input type="date" name="start_date" value="{{ $contract->start_date }}" required>

        <label>End date:</label>
        <input type="date" name="end_date" value="{{ $contract->end_date }}">

        <label>Services:</label>
        <select name="service_id[]" multiple>
            @foreach($services as $service)
                <option value="{{ $service->id }}" @if($contract->services->contains($service->id))
                    selected
                        @endif>{{ $service->name }}</option>
            @endforeach
        </select>
        
        <button type="submit">Save</button>
    </form>
</x-app-layout>