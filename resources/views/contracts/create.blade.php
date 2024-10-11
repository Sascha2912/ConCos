<x-app-layout>

    <x-slot:header>
        {{ __('app.create_new_contract') }}
    </x-slot:header>

    <form method="POST" action="{{ route('contracts.store') }}">
        @csrf
        <label for="customer_id">{{ __('app.customer') }}:</label>
        <select name="customer_id" id="customer_id">
            <option>{{ __('app.without_customer') }}</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->firstname }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <label>{{ __('app.name') }}:</label>
        <input type="text" name="name" required>

        <label>{{ __('app.hours') }}:</label>
        <input type="number" name="hours">

        <label>{{ __('app.monthly_costs') }}:</label>
        <input type="number" name="monthly_costs">

        <label>{{ __('app.flatrate') }}:</label>
        <input type="checkbox" name="flatrate">

        <label>{{ __('app.start_date') }}:</label>
        <input type="date" name="start_date" required>

        <label>{{ __('app.end_date') }}:</label>
        <input type="date" name="end_date">

        @if(isset($services) && !empty($services))
            <label>{{ __('app.services') }}:</label>
            <select name="service_id[]" multiple>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>

                @endforeach
            </select>
        @endif

        <button type="submit">{{ __('app.create_contract') }}</button>
    </form>
</x-app-layout>