<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('app.monthly_report_for') . ' - ' . $month . '/' . $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 18px;
            text-align: center;
            margin: 0;
            padding: 5px;
        }

        h3 {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: start;
        }

        .total-row {
            font-weight: bold;
            border-top: 2px solid #000;
        }

        .border-none {
            border: none;
        }

        .border-right-none {
            border-right: none;
        }

        .border-top {
            border-top: 1px solid #ddd;
        }

        .border-bottom {
            border-bottom: 1px solid #ddd;
        }

        .button-bottom-bar button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .button-bottom-bar button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h1>{{ __('app.monthly_report_for') . ' - ' . $month . '/' . $year }}</h1>
    <h2>{{ __('app.customer') }}: {{ $customer->name }}</h2>

    @if(isset($reportData['contracts']) && count($reportData['contracts']) > 0)
        @foreach($reportData['contracts'] as $contract)
            <h3>{{ __('app.contract') }}: {{ $contract['contract_name'] }}</h3>

            <table>
                <thead>
                <tr>
                    <td class="border-right-none">
                        {{ __('app.contract_costs') }}
                    </td>
                    <td class="border-none border-top"></td>
                    <td class="border-none border-top"></td>
                    <td class="border-none border-top"></td>
                    <td class="border-none border-top"></td>
                    <td class="text-center">
                        {{ number_format($contract['monthly_costs'], 2) }} €
                    </td>
                </tr>
                <tr>
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
                    <tr>
                        <td>{{ $service['service_name'] }}</td>
                        <td>{{ $service['agreed_hours'] }}</td>
                        <td>{{ $service['used_hours'] }}</td>
                        <td>{{ $service['additional_hours'] }}</td>
                        <td>{{ number_format($service['costs_per_hour'], 2) }} €</td>
                        <td>{{ number_format($service['additional_cost'], 2) }} €</td>
                    </tr>
                @endforeach
                <tr>
                    <th class="border-right-none">{{ __('app.total_contract_costs') }}:</th>
                    <th class="border-none border-bottom"></th>
                    <th class="border-none border-bottom"></th>
                    <th class="border-none border-bottom"></th>
                    <th class="border-none border-bottom"></th>
                    <th>{{ number_format($contract['contract_total_cost'], 2) }} €</th>
                </tr>
                </tbody>
            </table>
        @endforeach

        <div class="total-row" style="margin-top: 40px;">
            <h2>{{ __('app.total_monthly_costs') }}: {{ number_format($totalCost, 2) }} €</h2>
        </div>
    @else
        <h2>{{ __('app.no_contracts_available') }}</h2>
    @endif
</div>
</body>
</html>
