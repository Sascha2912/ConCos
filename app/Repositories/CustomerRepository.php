<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CustomerRepository {

    public function updateOrCreate(array $data, Request $request, Customer $customer = null) {
        if( !isset($data['create_date'])){
            $data['create_date'] = now()->format('Y-m-d');  // Hier das gewünschte Format setzen
        }
        
        if($customer){
            $customer->update($data);

        }else{
            $customer = Customer::create($data);
            $defaultContract = Contract::where('name', '-')->first();
            if($defaultContract){
                $customer->contracts()->attach($defaultContract->id, [
                    'start_date'  => Carbon::now(),
                    'create_date' => Carbon::now(),
                ]);
            }
        }

        $preparedContractDates = [];
        foreach($request->input('contracts') as $contract){
            $start_date = $request->input("contract_dates.{$contract['id']}.start_date");
            if( !$start_date){
                return redirect()->back()->with('error', 'Start date is required for all contracts.');
            }

            $end_date = $request->input("contract_dates.{$contract['id']}.end_date") ?? Carbon::parse($start_date)->addYears(2)->format('Y-m-d');

            $preparedContractDates[$contract['id']] = [
                'create_date' => $request->input("contract_dates.{$contract['id']}.create_date") ?? now()->format('Y-m-d'),
                'start_date'  => $start_date,
                'end_date'    => $end_date,
            ];
        }

        $customer->contracts()->sync($preparedContractDates);

        return $customer->fresh();
    }
}