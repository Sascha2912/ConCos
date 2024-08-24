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
    public function index() {
        $timelogs = Timelog::paginate(50);

        return view('timelogs.index', ['timelogs' => $timelogs]);
    }

    /**
     * Show the form for creating a new resource.
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

        return redirect(route('timelogs.show', ['timelog' => $timelog]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Timelog $timelog) {
        if($request->expectsJson()){

            return response([
                'timelog' => $timelog,
            ]);
        }

        return view('timelogs.show', ['timelog' => $timelog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timelog $timelog) {
        $contracts = Contract::paginate();
        $customers = Customer::paginate();
        $services = Service::paginate();

        return view('timelogs.edit',
            ['timelog' => $timelog, 'contracts' => $contracts, 'customers' => $customers, 'services' => $services]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timelog $timelog) {
        $data = $this->validate($request, Timelog::validationRules());
        $timelog = $this->timelogRepository->updateOrCreate($data, $timelog);

        return redirect(route('timelogs.show', ['timelog' => $timelog]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timelog $timelog) {
        $timelog->delete();

        return redirect(route('timelogs.index'));
    }
}