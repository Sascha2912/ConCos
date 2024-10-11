<x-app-layout>

    <x-slot:header>
        {{ __('app.edit_time_entry') }}
    </x-slot:header>

    <form method="POST" action="{{ route('timelogs.update', $timelog->id) }}">
        @csrf
        @method('PUT')

        <label>{{ __('app.customer') }}:</label>
        <select name="customer_id" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                        @if($timelog->customer_id == $customer->id) selected @endif>{{ $customer->firstname }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <label>{{ __('app.service') }}:</label>
        <select name="service_id" required>
            @foreach($services as $service)
                <option value="{{ $service->id }}"
                        @if($timelog->service_id == $service->id) selected @endif>{{ $service->name }}</option>
            @endforeach
        </select>

        <input type="number" name="contract_id" value="{{ $timelog->contract_id }}" hidden>

        <label>{{ __('app.hours') }}:</label>
        <input type="number" name="hours" value="{{ $timelog->hours }}" required>

        <label>{{ __('app.date') }}:</label>
        <input type="date" name="date" value="{{ $timelog->date }}" required>

        <button type="submit">{{ __('app.save') }}</button>
    </form>
</x-app-layout>