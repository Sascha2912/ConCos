<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class InvoiceController extends Controller {
    public function create(Customer $customer) {
        $usedHours = $customer->timelogs->sum('hours');
        $contractHours = $customer->contracts->sum('hours');
        $monthlyCosts = $customer->contracts->sum('monthlyCosts');

        $extraCosts = 0;
        foreach($customer->timelogs as $timelog){
            $contract = $timelog->vertrag;
            $service = $timelog->service;

            // Zusatzkosten, wenn Service nicht Teil des contracts ist
            if( !$contract || !$contract->services->contains($service->id)){
                $extraCosts += $service->cost_per_hour * $timelog->hours;
            }

            // Zusatzkosten, wenn die hours des contracts überschritten wurden
            if($usedHours > $contractHours){
                $overtime = $usedHours - $contractHours;
                $extraCosts += $overtime * $service->cost_per_hour;
            }
        }

        $total = $monthlyCosts + $extraCosts;

        return view('invoices.create', [
            'customer'      => $customer,
            'usedHours'     => $usedHours,
            'contractHours' => $contractHours,
            'monthlyCosts'  => $monthlyCosts,
            'extraCosts'    => $extraCosts,
            'total'         => $total,
        ]);

    }
}
