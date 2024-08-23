<x-app-layout>

    <x-slot:header>
        Edit Customer
    </x-slot:header>

    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        <label>Firstname:</label>
        <input type="text" name="firstname" value="{{ $customer->firstname }}" required>

        <label>Lastname:</label>
        <input type="text" name="lastname" value="{{ $customer->lastname }}" required>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $customer->email }}" required>

        <label>Street:</label>
        <input type="text" name="street" value="{{ $customer->street }}">

        <label>House number:</label>
        <input type="text" name="house_number" value="{{ $customer->house_number }}">

        <label>Zip code:</label>
        <input type="text" name="zip_code" value="{{ $customer->zip_code }}">

        <label>City:</label>
        <input type="text" name="city" value="{{ $customer->city }}">

        <label>Phone:</label>
        <input type="text" name="phone" value="{{ $customer->phone }}">
        
        <label>Contracts:</label>
        <select name="contract_id[]" multiple>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }} @if($customer->contracts->contains($contract->id)) selected @endif">{{ $contract->id }}</option>
            @endforeach
        </select>

        <button type="submit">Edit customer</button>
    </form>
</x-app-layout>