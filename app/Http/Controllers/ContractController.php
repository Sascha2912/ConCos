<?php

namespace App\Http\Controllers;


use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Repositories\ContractRepository;
use Illuminate\Http\Request;

class ContractController extends Controller {
    protected ContractRepository $contractRepository;

    public function __construct(ContractRepository $contractRepository) {
        $this->contractRepository = $contractRepository;
        // $this->authorizeResource(Contract::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $contracts = Contract::paginate(50);

        return view('contracts.index', ['contracts' => $contracts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $services = Service::all();
        $customers = Customer::all();

        return view('contracts.create',
            ['contract' => new Contract(), 'services' => $services, 'customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Contract::validationRules(true));
        $contract = $this->contractRepository->updateOrCreate($data);

        if($request->service_id){
            $contract->services()->attach($request->service_id);
        }

        if($request->expectsJson()){

            return response([
                'contract' => $contract,
                'success'  => true,
            ]);
        }

        return redirect(route('contracts.show', ['contract' => $contract]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Contract $contract) {
        if($request->expectsJson()){

            return response([
                'contract' => $contract,
            ]);
        }

        return view('contracts.show', ['contract' => $contract]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract) {
        $services = Service::paginate();

        return view('contracts.edit', ['contract' => $contract, 'services' => $services]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract) {
        $data = $this->validate($request, Contract::validationRules());
        $contract = $this->contractRepository->updateOrCreate($data, $contract);

        if($request->service_id){
            $contract->services()->attach($request->service_id);
        }

        return redirect(route('contracts.show', ['contract' => $contract]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract) {
        $contract->delete();

        return redirect(route('contracts.index'));
    }
}