<?php

namespace App\Traits;

use Carbon\Carbon;

trait ReportsHelperTrait {
    public function generateReportData($customer, $month, $year) {
        $reportData = [];
        $totalCost = 0;
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        foreach($customer->contracts as $contract){
            $contractData = [
                'contract_name'       => $contract->name,
                'monthly_costs'       => $contract->monthly_costs,
                'services'            => [],
                'contract_total_cost' => 0,
            ];

            $contractTotalCost = $contract->monthly_costs;

            foreach($contract->services as $service){
                $timelogHours = $customer->timelogs()
                    ->where('contract_id', $contract->id)
                    ->where('service_id', $service->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('hours');

                $additionalHours = max(0, $timelogHours - $service->pivot->hours);
                $additionalCost = $additionalHours * $service->costs_per_hour;

                $contractData['services'][] = [
                    'service_name'     => $service->name,
                    'agreed_hours'     => $service->pivot->hours,
                    'used_hours'       => $timelogHours,
                    'additional_hours' => $additionalHours,
                    'additional_cost'  => $additionalCost,
                    'costs_per_hour'   => $service->costs_per_hour,
                ];

                $contractTotalCost += $additionalCost;
            }

            $contractData['contract_total_cost'] = $contractTotalCost;
            $reportData['contracts'][] = $contractData;
            $totalCost += $contractTotalCost;
        }

        $reportData['totalCost'] = $totalCost;

        return $reportData;
    }
}
