<x-app-layout>

    <x-slot:header>
        {{ __('app.create_new_time_log') }}
    </x-slot:header>

    <form method="POST" action="{{ route('timelogs.store') }}">
        @csrf

        <label>{{ __('app.customer') }}:</label>
        <select name="customer_id" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->firstname }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <label>{{ __('app.contract') }}:</label>
        <select name="contract_id" required>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
            @endforeach
        </select>

        <label>{{ __('app.service') }}:</label>
        <select name="service_id" required>
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>

        <label>{{ __('app.hours') }}:</label>
        <input type="number" name="hours" required>

        <label>{{ __('app.date') }}:</label>
        <input type="date" name="date" required>

        <button type="submit">{{ __('app.log') }}</button>
    </form>
</x-app-layout>