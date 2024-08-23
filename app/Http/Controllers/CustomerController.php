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
        //$this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $customers = Customer::paginate(50);

        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
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

        if($request->contract_id){
            $customer->contract()->attach($request->contract_id);
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
        if($request->expectsJson()){

            return response([
                'customer' => $customer,
            ]);
        }

        return view('customers.edit', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
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
    public function destroy(Customer $customer) {
        $customer->delete();

        return redirect(route('customers.index'));
    }
}