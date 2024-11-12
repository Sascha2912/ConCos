<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends Controller {
    protected ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository) {
        $this->serviceRepository = $serviceRepository;
        $this->authorizeResource(Service::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $services = Service::paginate(10);

        return view('services.index', ['services' => $services]);
    }

    /**
     * Show the forms for creating a new resource.
     */
    public function create() {

        return view('services.create', ['service' => new Service()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Service::validationRules());
        $service = $this->serviceRepository->updateOrCreate($data);

        // Hole den Standardvertrag '-' und weise ihn dem neuen Service zu
        $defaultContract = Contract::where('name', '-')->first();
        if($defaultContract){
            $service->contracts()->attach($defaultContract, ['hours' => null]);
        }

        if($request->expectsJson()){

            return response([
                'service' => $service,
                'success' => true,
            ]);
        }

        session()->flash('message', __('app.service_created_successfully'));

        return redirect(route('services.edit', ['service' => $service]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Service $service) {
        if($request->expectsJson()){

            return response([
                'service' => $service,
            ]);
        }

        return view('services.show', ['service' => $service]);
    }

    /**
     * Show the forms for editing the specified resource.
     */
    public function edit(Service $service) {

        return view('services.edit', ['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service) {
        $data = $this->validate($request, Service::validationRules());
        $service = $this->serviceRepository->updateOrCreate($data, $service);

        // Stelle sicher, dass der Service immer dem Standardvertrag zugeordnet bleibt
        $defaultContract = Contract::where('name', '-')->first();
        if($defaultContract && !$service->contracts()->where('contract_id', $defaultContract->id)->exists()){
            $service->contracts()->sync($defaultContract->id);
        }

        session()->flash('message', __('app.service_updated_successfully'));

        return redirect(route('services.edit', ['service' => $service]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service) {
        $service->delete();

        return redirect(route('services.index'));
    }
}