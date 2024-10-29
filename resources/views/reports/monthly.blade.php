<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('app.monthly_report_for'). ' ' . $customer->name }}</title>
    <style>
        /* Grundstil für die gesamte Seite */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1, h2, h3 {
            color: #333;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 1.8em;
            margin-bottom: 16px;
            text-align: center;
        }

        h2 {
            font-size: 1.5em;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h3 {
            font-size: 1.3em;
            margin-top: 44px;
        }

        /* Tabelle */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Rahmen für Abschnitte */
        .contract-section {
            margin-bottom: 24px;
        }

        .monthly-cost {
            text-align: right;
            font-size: 1.1em;
            font-weight: bold;
            margin-top: 8px;
            color: #444;
        }

        /* Download-Button */
        .button-bottom-bar {
            text-align: center;
            margin-top: 20px;
        }

        .button-bottom-bar button {
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-bottom-bar button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<h1>{{ __('app.monthly_report_for') }} {{ $month }}/{{ $year }}</h1>
<h2>{{ __('app.customer') }}:</h2>
<h2>{{ $customer->name }}</h2>

@foreach($reportData['contracts'] as $contract)
    <div class="contract-section">
        <h3>{{ __('app.contract') }}: {{ $contract['contract_name'] }}</h3>

        <table>
            <thead>
            <tr>
                <th>{{ __('app.service') }}</th>
                <th>{{ __('app.agreed_hours') }}</th>
                <th>{{ __('app.used_hours') }}</th>
                <th>{{ __('app.additional_hours') }}</th>
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
                    <td>{{ number_format($service['additional_cost'], 2) }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p class="monthly-cost">
            {{ __('app.monthly_costs') }}: {{ number_format($contract['monthly_costs'], 2) }} €
        </p>
    </div>
@endforeach

</body>
</html>