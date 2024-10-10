<x-app-layout>

    <x-slot:header>
        {{ __('app.edit_customer') }}
    </x-slot:header>

    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')

        <label>{{ __('app.firstname') }}:</label>
        <input type="text" name="firstname" value="{{ $customer->firstname }}" required>

        <label>{{ __('app.lastname') }}:</label>
        <input type="text" name="lastname" value="{{ $customer->lastname }}" required>

        <label>{{ __('app.email') }}:</label>
        <input type="email" name="email" value="{{ $customer->email }}" required>

        <label>{{ __('app.street') }}:</label>
        <input type="text" name="street" value="{{ $customer->street }}">

        <label>{{ __('app.house_number') }}:</label>
        <input type="text" name="house_number" value="{{ $customer->house_number }}">

        <label>{{ __('app.zip_code') }}:</label>
        <input type="text" name="zip_code" value="{{ $customer->zip_code }}">

        <label>{{ __('app.city') }}:</label>
        <input type="text" name="city" value="{{ $customer->city }}">

        <label>{{ __('app.phone') }}:</label>
        <input type="text" name="phone" value="{{ $customer->phone }}">

        <label>{{ __('app.contracts') }}:</label>
        <select name="contract_id[]" multiple>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }} @if($customer->contracts->contains($contract->id)) selected @endif">{{ $contract->id }}</option>
            @endforeach
        </select>

        <button type="submit">{{ __('app.save') }}</button>
    </form>
</x-app-layout>