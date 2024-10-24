<x-app-layout>
    <form method="POST" action="{{ route('timelogs.store') }}">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.create_new_time_log') }}</h1>
            <div class="edit-wrapper">
                <x-forms.label for="customer_id[]">{{ __('app.customer') }}:</x-forms.label>
                <select name="customer_id" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                                @if($timelog->customer_id == $customer->id) selected @endif>{{ $customer->firstname }} {{ $customer->lastname }}</option>
                    @endforeach
                </select>

                <x-forms.label>{{ __('app.contract') }}:</x-forms.label>
                <select name="contract_id" required>
                    @foreach($contracts as $contract)
                        <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                    @endforeach
                </select>

                <x-forms.label for="service_id[]">{{ __('app.service') }}:</x-forms.label>
                <select name="service_id" required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                                @if($timelog->service_id == $service->id) selected @endif>{{ $service->name }}</option>
                    @endforeach
                </select>

                <input type="number" name="contract_id" value="{{ $timelog->contract_id }}" hidden>

                <div>
                    <x-forms.field>
                        <x-forms.label for="hours">{{ __('app.hours') }}:</x-forms.label>
                        <x-forms.input name="hours" id="hours" value="{{ $timelog->hours }}"/>
                    </x-forms.field>
                    <x-forms.error name="hours"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="date">{{ __('app.date') }}:</x-forms.label>
                        <x-forms.input name="date" id="date" value="{{ $timelog->date }}"/>
                    </x-forms.field>
                    <x-forms.error name="date"/>
                </div>

            </div>
        </div>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/timelogs"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.button>{{ __('app.log') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>