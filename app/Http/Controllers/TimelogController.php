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
        $this->authorizeResource(timelog::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($customer_id) {
        $customer = Customer::findOrFail($customer_id);
        $timelogs = $customer->timelogs()->orderBy('created_at', 'desc')->paginate(10);

        return view('timelogs.index', [
            'timelogs' => $timelogs,
            'customer' => $customer,
        ]);
    }

    /**
     * Show the forms for creating a new resource.
     */
    public function create($customer_id) {
        $customer = Customer::findOrFail($customer_id);
        $contracts = $customer->contracts; // Lade nur Verträge für diesen Kunden
        $services = Service::all();        // Alternativ kannst du Services auch spezifisch laden

        return view('timelogs.create', [
            'customer'  => $customer,
            'contracts' => $contracts,
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

        if($request->expectsJson()){

            return response([
                'customer' => $customer,
                'timelog'  => $timelog,
                'success'  => true,
            ]);
        }

        return view('timelogs.show', [
            'customer' => $customer,
            'timelog'  => $timelog,
        ]);
    }

    /**
     * Show the forms for editing the specified resource.
     */
    public function edit(Timelog $timelog) {
        $customer = $timelog->customer;

        return view('timelogs.edit',
            [
                'timelog'  => $timelog,
                'customer' => $customer,
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

        return redirect(route('customers.timelogs.index', $timelog->customer_id));
    }
}