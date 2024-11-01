<div class="wrapper">
    <div class="flex justify-center mb-4 w-full">
        <select wire:model="year" wire:change="loadMonthlyReport()" class="h-8 w-2/12">
            @foreach(range($customer->contracts()->withPivot('start_date')->get()->min('start_date') ? Carbon::parse($customer->contracts()->withPivot('start_date')->get()->min('start_date'))->year : now()->year, now()->year) as $yearOption)
                <option value="{{ $yearOption }}">{{ $yearOption }}</option>
            @endforeach
        </select>

    </div>

    <div class="grid grid-cols-12  gap-4 mt-4 mb-12">
        @foreach(range(1, 12) as $monthOption)
            <div wire:click="loadMonthlyReport({{ $monthOption }}, {{ $year }})"
                 class="cursor-pointer p-2 rounded border text-center {{ $monthOption == $month ? 'bg-blue-400 text-white' : 'bg-gray-200' }}">
                {{ __('app.' . strtolower(DateTime::createFromFormat('!m', $monthOption)->format('F')))  }}
            </div>
        @endforeach
    </div>

    <h1 class="text-4xl mb-4">{{ __('app.monthly_report_for'). ' - ' . $month . '/'. $year }}</h1>

    @if($reportData)
        <h2 class="text-center p-0 m-0 text-3xl">
            {{ __('app.customer') }}: {{ $customer->name }}
        </h2>
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
        <h2 class="text-2xl mt-12 mb-4">{{ __('app.no_report_data_available') }}</h2>
    @endif
</div>
