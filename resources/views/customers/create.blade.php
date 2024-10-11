<x-app-layout>

    <x-slot:header>
        {{ __('app.create_new_customer') }}
    </x-slot:header>

    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <label>{{ __('app.firstname') }}:</label>
        <input type="text" name="firstname" required>

        <label>{{ __('app.lastname') }}:</label>
        <input type="text" name="lastname" required>

        <label>{{ __('app.email') }}:</label>
        <input type="email" name="email" required>

        <label>{{ __('app.street') }}:</label>
        <input type="text" name="street">

        <label>{{ __('app.house_number') }}:</label>
        <input type="text" name="house_number">

        <label>{{ __('app.zip_code') }}:</label>
        <input type="text" name="zip_code">

        <label>{{ __('app.city') }}:</label>
        <input type="text" name="city">

        <label>{{ __('app.phone') }}:</label>
        <input type="text" name="phone">

        <label>{{ __('app.contracts') }}:</label>
        <select name="contract_id[]" multiple>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
            @endforeach
        </select>

        <button type="submit">{{ __('app.create_customer') }}</button>
    </form>
</x-app-layout>