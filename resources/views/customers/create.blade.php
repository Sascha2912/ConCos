<x-app-layout>

    <x-slot:header>
        Create new Customer
    </x-slot:header>

    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <label>Firstname:</label>
        <input type="text" name="firstname" required>

        <label>Lastname:</label>
        <input type="text" name="lastname" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Street:</label>
        <input type="text" name="street">

        <label>House number:</label>
        <input type="text" name="house_number">

        <label>Zip Code:</label>
        <input type="text" name="zip_code">

        <label>City:</label>
        <input type="text" name="city">

        <label>Phone:</label>
        <input type="text" name="phone">
        
        <label>Contracts:</label>
        <select name="contract_id[]" multiple>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">{{ $contract->id }}</option>
            @endforeach
        </select>

        <button type="submit">Create customer</button>
    </form>
</x-app-layout>