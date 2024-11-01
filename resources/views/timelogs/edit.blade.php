<x-app-layout>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <livewire:timelogs.edit :customer="$customer" :timelog="$timelog"/>
</x-app-layout>