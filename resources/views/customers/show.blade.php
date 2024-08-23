<x-app-layout>

    <x-slot:header>
        {{ $customer->firstname }}  {{ $customer->lastname }}
    </x-slot:header>

    <p>Email: {{ $customer->email }}</p>
    <p>Street: {{ $customer->street }}</p>
    <p>House number: {{ $customer->house_number }}</p>
    <p>Zip code: {{ $customer->zip_code }}</p>
    <p>City: {{ $customer->city }}</p>
    <p>Phone: {{ $customer->phone }}</p>

    <h2>Contracts</h2>
    <ul>
        @foreach($customer->contracts as $contract)
            <li>Contract ID: {{ $contract->id }}</li>
        @endforeach
    </ul>

</x-app-layout>