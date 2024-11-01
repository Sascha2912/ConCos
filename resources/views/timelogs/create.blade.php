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
    <livewire:timelogs.create :customer="$customer" :contracts="$contracts" :services="$services"/>
</x-app-layout>