<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;

class CustomerController extends Controller {
    protected CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository) {
        $this->customerRepository = $customerRepository;
        $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $customers = Customer::paginate(10);

        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the forms for creating a new resource.
     */
    public function create() {
        $contracts = Contract::all();

        return view('customers.create',
            ['contracts' => $contracts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Customer::validationRules(true));
        
        $customer = $this->customerRepository->updateOrCreate($data, $request);

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
        $contracts = $customer->contracts()->withPivot('start_date', 'end_date')->get();

        if($request->expectsJson()){

            return response([
                'customer'  => $customer,
                'contracts' => $contracts,
            ]);
        }

        if($request->routeIs('monthly.report.show')){

            return view('customers.monthly-report', [
                'customer'  => $customer,
                'contracts' => $contracts,
            ]);
        }else{
            return view('customers.show', [
                'customer'  => $customer,
                'contracts' => $contracts,
            ]);
        }
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

        $customer = $this->customerRepository->updateOrCreate($data, $request, $customer);

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