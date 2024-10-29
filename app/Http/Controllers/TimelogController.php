<?php

namespace App\Http\Controllers;


use App\Models\Timelog;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\Service;
use App\Repositories\TimelogRepository;
use Illuminate\Http\Request;

class TimelogController extends Controller {
    protected TimelogRepository $timelogRepository;

    public function __construct(TimelogRepository $timelogRepository) {
        $this->timelogRepository = $timelogRepository;
        // $this->authorizeResource(timelog::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Customer $customer) {
        $timelogs = $customer->timelogs()->orderBy('created_at', 'desc')->simplePaginate(5);

        return view('timelogs.index', [
            'timelogs' => $timelogs,
            'customer' => $customer,
        ]);
    }

    /**
     * Show the forms for creating a new resource.
     */
    public function create() {
        $contracts = Contract::paginate();
        $customers = Customer::paginate();
        $services = Service::paginate();

        return view('timelogs.create',
            [
                'timelog'   => new Timelog(),
                'contracts' => $contracts,
                'customers' => $customers,
                'services'  => $services,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Timelog::validationRules(true));
        $timelog = $this->timelogRepository->updateOrCreate($data);

        if($request->expectsJson()){

            return response([
                'timelog' => $timelog,
                'success' => true,
            ]);
        }

        return redirect(route('timelogs.edit', ['timelog' => $timelog]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Timelog $timelog) {
        $customer = $timelog->customer;
        $contract = $timelog->contract;


        $contracts = $customer ? $customer->contracts()->get() : collect();
        $services = $contract->services->get();

        if($request->expectsJson()){

            return response([

                'timelog'   => $timelog,
                'customer'  => $customer,
                'contracts' => $contracts,
                'services'  => $services,

            ]);
        }

        return view('timelogs.show',
            [
                'timelog'   => $timelog,
                'customer'  => $customer,
                'contracts' => $contracts,
                'services'  => $services,
            ]);
    }

    /**
     * Show the forms for editing the specified resource.
     */
    public function edit(Timelog $timelog) {
        $customer = $timelog->customer;
        $contract = $timelog->contract;


        $contracts = $customer->contracts;
        $services = $contract->services;

        // Erzeuge ein Mapping von Service-ID zu Contract-ID
        $serviceContractMap = $contracts->flatMap(function($contract) {
            return $contract->services->mapWithKeys(function($service) use ($contract) {
                return [$service->id => $contract->id];
            });
        });

        return view('timelogs.edit',
            [
                'timelog'            => $timelog,
                'customer'           => $customer,
                'contracts'          => $contracts,
                'services'           => $services,
                'serviceContractMap' => $serviceContractMap,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timelog $timelog) {
        $data = $this->validate($request, Timelog::validationRules());
        $timelog = $this->timelogRepository->updateOrCreate($data, $timelog);

        return redirect(route('timelogs.edit', ['timelog' => $timelog]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timelog $timelog) {
        $timelog->delete();

        return redirect(route('timelogs.index'));
    }
}