<x-app-layout>

    <x-slot:header>
        Create new Contract
    </x-slot:header>

    <form method="POST" action="{{ route('contracts.store') }}">
        @csrf
        <select name="customer_id">
            <option>without customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->firstname }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Hours:</label>
        <input type="number" name="hours">

        <label>Monthly costs:</label>
        <input type="number" name="monthly_costs">

        <label>Flatrate:</label>
        <input type="checkbox" name="flatrate">

        <label>Start date:</label>
        <input type="date" name="start_date" required>

        <label>End date:</label>
        <input type="date" name="end_date">

        @if(isset($services) && !empty($services))
            <label>Services:</label>
            <select name="service_id[]" multiple>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>

                @endforeach
            </select>
        @endif

        <button type="submit">Create contract</button>
    </form>
</x-app-layout>