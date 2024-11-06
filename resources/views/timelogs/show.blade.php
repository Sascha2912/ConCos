<x-app-layout>
    <div class="wrapper">
        <h1>{{ __('app.time_log') }}</h1>
        <form>
            @csrf
            <x-forms.input-field
                    name="hours"
                    label="{{ __('app.hours') }}"
                    type="text"
                    :value="$timelog->hours"
                    :required="true"
                    :disabled="true"
            />

            <x-forms.input-field
                    name="date"
                    label="{{ __('app.date') }}"
                    type="date"
                    :value="$timelog->date"
                    :required="true"
                    :disabled="true"
            />

            <x-forms.textarea-field
                    name="description"
                    label="{{ __('app.description') }}"
                    type="text"
                    rows="9"
                    :disabled="true"
            />
        </form>
        <!-- Button-Bottom-Bar -->
        <div class="button-bottom-bar">
            <x-partials.action-link href="{{ route('customers.timelogs.index', $customer->id) }}"
                                    class="back ">{{ __('app.back') }}</x-partials.action-link>
        </div>
    </div>
</x-app-layout>