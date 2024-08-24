<x-app-layout>

    <x-slot:header>
        Edit Time log
    </x-slot:header>

    <form method="POST" action="{{ route('timelogs.update', $timelog->id) }}">
        @csrf
        @method('PUT')

        <label>Customer:</label>
        <select name="customer_id" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                        @if($timelog->customer_id == $customer->id) selected @endif>{{ $customer->firstname }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <label>Service:</label>
        <select name="service_id" required>
            @foreach($services as $service)
                <option value="{{ $service->id }}"
                        @if($timelog->service_id == $service->id) selected @endif>{{ $service->name }}</option>
            @endforeach
        </select>

        <input type="number" name="contract_id" value="{{ $timelog->contract_id }}" hidden>

        <label>Hours:</label>
        <input type="number" name="hours" value="{{ $timelog->hours }}" required>

        <label>Date:</label>
        <input type="date" name="date" value="{{ $timelog->date }}" required>

        <button type="submit">Save</button>
    </form>
</x-app-layout>