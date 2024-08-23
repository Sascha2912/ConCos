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

        <label>Phone:</label>
        <input type="text" name="phone" value="{{ $customer->phone }}">

        <label>Address:</label>
        <textarea name="address">{{ $customer->address }}</textarea>

        <label>Contracts:</label>
        <select name="contract_id[]" multiple>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }} @if($customer->contracts->contains($contract->id)) selected @endif">{{ $contract->id }}</option>
            @endforeach
        </select>

        <button type="submit">Edit customer</button>
    </form>
</x-app-layout>