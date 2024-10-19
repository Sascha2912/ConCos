<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;

class CustomerController extends Controller {
    protected CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository) {
        $this->customerRepository = $customerRepository;
        // $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $customers = Customer::paginate(30);

        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the forms for creating a new resource.
     */
    public function create() {
        $contracts = Contract::paginate();

        return view('customers.create',
            ['customer' => new Customer(), 'contracts' => $contracts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Customer::validationRules(true));
        $customer = $this->customerRepository->updateOrCreate($data);

        if($request->routeIs('customer.contracts.destroy')){
            $customer->contracts()->attach($request->contract_id);

            return redirect()->back()->with('success', 'Vertrag wurde dem Kunden erfolgreich hinzugefügt.');
        }
        if($request->contract_id){
            $customer->contracts()->attach($request->contract_id);
        }

        if($request->expectsJson()){

            return response([
                'customer' => $customer,
                'success'  => true,
            ]);
        }

        return redirect(route('customers.edit', ['customer' => $customer]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Customer $customer) {
        $customerContracts = $customer->contracts()->get();
        $contracts = Contract::all();

        $usedHours = $customer->timelogs()->sum('hours');
        $contractHours = $customer->contracts->sum('hours');
        $monthlyCosts = $customer->contracts->sum('monthly_costs');

        $extraCosts = 0;
        foreach($customer->timelogs as $timelog){
            $contract = $timelog->contract;
            $service = $timelog->service;

            if( !$contract || !$contract->services->contains($service->id)){
                $extraCosts += $service->cost_per_hour * $timelog->hours;
            }

            if($usedHours > $contractHours){
                $overtime = $usedHours - $contractHours;
                $extraCosts += $overtime * $service->cost_per_hour;
            }
        }

        if($request->expectsJson()){

            return response([
                'customer'          => $customer,
                'customerContracts' => $customerContracts,
                'usedHours'         => $usedHours,
                'contractHours'     => $contractHours,
                'monthlyCosts'      => $monthlyCosts,
                'extraCosts'        => $extraCosts,
                'contracts'         => $contracts,
            ]);
        }

        return view('customers.edit', [
            'customer'      => $customer,
            'usedHours'     => $usedHours,
            'contractHours' => $contractHours,
            'monthlyCosts'  => $monthlyCosts,
            'extraCosts'    => $extraCosts,
            'contracts'     => $contracts,
        ]);
    }

    /**
     * Show the forms for editing the specified resource.
     */
    public function edit(Customer $customer) {
        $contracts = $customer->contracts()->get();

        return view('customers.edit', ['customer' => $customer, 'contracts' => $contracts]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer) {
        $data = $this->validate($request, Customer::validationRules());
        $customer = $this->customerRepository->updateOrCreate($data, $customer);

        if($request->contract_id){
            $customer->contracts()->sync($request->contract_id);
        }

        return redirect(route('customers.edit', ['customer' => $customer]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Customer $customer, Contract $contract = null) {

        if($request->routeIs('customer.contracts.destroy')){
            $customer->contracts()->detach($contract->id);

            return redirect()->back()->with('success', 'Vertrag wurde erfolgreich vom Kunden entfernt.');
        }else{
            $customer->delete();

            return redirect(route('customers.index'));
        }

    }
}