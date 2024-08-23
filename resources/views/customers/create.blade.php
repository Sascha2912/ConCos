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

        <label>Phone:</label>
        <input type="text" name="phone">

        <label>Address:</label>
        <textarea name="address"></textarea>

        <label>Contracts:</label>
        <select name="contract_id[]" multiple>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">{{ $contract->id }}</option>
            @endforeach
        </select>

        <button type="submit">Create customer</button>
    </form>
</x-app-layout>