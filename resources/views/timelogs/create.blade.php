<x-app-layout>

    <x-slot:header>
        Create new Time log
    </x-slot:header>

    <form method="POST" action="{{ route('timelogs.store') }}">
        @csrf

        <label>Customer:</label>
        <select name="customer_id" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->firstname }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <label>Contract:</label>
        <select name="contract_id" required>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
            @endforeach
        </select>

        <label>Service:</label>
        <select name="service_id" required>
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>

        <label>Hours:</label>
        <input type="number" name="hours" required>

        <label>Date:</label>
        <input type="date" name="date" required>

        <button type="submit">Log</button>
    </form>
</x-app-layout>