<x-app-layout>

    <x-slot:header>
        Create new Contract
    </x-slot:header>

    <form method="POST" action="{{ route('contracts.store') }}">
        @csrf
        <label>Hours:</label>
        <input type="number" name="hours" required>

        <label>Monthly costs:</label>
        <input type="number" name="monthly_costs" required>

        <label>Flatrate:</label>
        <input type="checkbox" name="flatrate" required>

        <label>Start date:</label>
        <input type="date" name="start_date">

        <label>End date:</label>
        <input type="date" name="end_date">

        <label>Services:</label>
        <select name="service_id[]" multiple>
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>

        <button type="submit">Create contract</button>
    </form>
</x-app-layout>