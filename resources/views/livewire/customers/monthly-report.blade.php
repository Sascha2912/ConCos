<div class="wrapper">
    <h1 class="text-4xl mb-4">{{ __('app.monthly_report_for'). ' - ' . $month . '/'. $year }}</h1>
    <h2 class="text-center p-0 m-0 text-3xl">
        {{ __('app.customer') }}: {{ $customer->name }}
    </h2>

    @if(isset($reportData['contracts']) && count($reportData['contracts']) > 0)
        @foreach($reportData['contracts']  as $contract)
            <div class="mb-12">

                <h3 class="text-2xl mt-12 mb-4">{{ __('app.contract') }}: {{ $contract['contract_name'] }}</h3>

                <div class="min-w-full rounded-lg bg-white border">
                    <table>
                        <thead>
                        <tr class="border-b-2">
                            <td colspan="5" class="text-start">
                                {{ __('app.contract_costs') }}
                            </td>
                            <td class="text-center">
                                {{ number_format($contract['monthly_costs'], 2) }} €
                            </td>
                        </tr>
                        <tr class="border rounded-lg">
                            <th>{{ __('app.service') }}</th>
                            <th>{{ __('app.agreed_hours') }}</th>
                            <th>{{ __('app.used_hours') }}</th>
                            <th>{{ __('app.additional_hours') }}</th>
                            <th>{{ __('app.costs_per_hour') }}</th>
                            <th>{{ __('app.additional_cost') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contract['services'] as $service)
                            <tr class="border text-center rounded-lg">
                                <td>{{ $service['service_name'] }}</td>
                                <td>{{ $service['agreed_hours'] }}</td>
                                <td>{{ $service['used_hours'] }}</td>
                                <td>{{ $service['additional_hours'] }}</td>
                                <td>{{ number_format($service['costs_per_hour'], 2) }} €</td>
                                <td>{{ number_format($service['additional_cost'], 2) }} €</td>
                            </tr>
                        @endforeach
                        <tr class="border-t-2 border-black">
                            <th colspan="5" class="text-start">
                                {{ __('app.total_contract_costs') }}:
                            </th>
                            <th>
                                {{ number_format($contract['contract_total_cost'], 2) }} €
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        @endforeach
        <div>
            <h2 class="p-0 m-0 text-2xl flex justify-between">
                <span>{{ __('app.total_monthly_costs') }}</span>
                <span>{{ number_format($totalCost, 2) }} €</span>

            </h2>
        </div>
        <div class="button-bottom-bar">
            <button wire:click="downloadPdf">{{ __('app.download_pdf') }}</button>
        </div>
    @else
        <h2 class="text-2xl mt-12 mb-4">{{ __('app.no_contracts_available') }}</h2>
    @endif
</div>
