<div class="wrapper">
    <h1 class="text-4xl mb-4">{{ __('app.monthly_report_for'). ' - ' . $month . '/'. $year }}</h1>
    <h2 class="text-center p-0 m-0 text-3xl">{{ __('app.customer') }}:</h2>
    <h2 class="text-center p-0 m-0 text-3xl">{{ $customer->name }}</h2>

    @foreach($reportData['contracts']  as $contract)
        <div class="mb-12">
            <h3 class="text-2xl mt-12 mb-4">{{ __('app.contract') }}: {{ $contract['contract_name'] }}</h3>

            <div class="min-w-full rounded-lg bg-white border">
                <table class="min-w-full">
                    <thead>
                    <tr class="border rounded-lg">
                        <th class="px-4 py-2">{{ __('app.service') }}</th>
                        <th class="px-4 py-2">{{ __('app.agreed_hours') }}</th>
                        <th class="px-4 py-2">{{ __('app.used_hours') }}</th>
                        <th class="px-4 py-2">{{ __('app.additional_hours') }}</th>
                        <th class="px-4 py-2">{{ __('app.additional_cost') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contract['services'] as $service)
                        <tr class="border text-center rounded-lg">
                            <td class="px-4 py-2">{{ $service['service_name'] }}</td>
                            <td class="px-4 py-2">{{ $service['agreed_hours'] }}</td>
                            <td class="px-4 py-2">{{ $service['used_hours'] }}</td>
                            <td class="px-4 py-2">{{ $service['additional_hours'] }}</td>
                            <td class="px-4 py-2">{{ number_format($service['additional_cost'], 2) }} €</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-lg mt-1 text-end">{{ __('app.monthly_costs') }}
                : {{ number_format($contract['monthly_costs'], 2) }}
                €</p>
        </div>
    @endforeach

    <div class="button-bottom-bar">
        <button wire:click="downloadPdf">{{ __('app.download_pdf') }}</button>
    </div>
</div>
