<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends Controller {
    protected ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository) {
        $this->serviceRepository = $serviceRepository;
        // $this->authorizeResource(Service::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $services = Service::paginate(50);

        return view('services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {

        return view('services.create', ['service' => new Service()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Service::validationRules(true));
        $service = $this->serviceRepository->updateOrCreate($data);

        if($request->expectsJson()){

            return response([
                'service' => $service,
                'success' => true,
            ]);
        }

        return redirect(route('services.show', ['service' => $service]));
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
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service) {

        return view('services.edit', ['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service) {
        $data = $this->validate($request, Service::validationRules());
        $service = $this->serviceRepository->updateOrCreate($data);

        return redirect(route('services.show', ['service' => $service]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service) {
        $service->delete();

        return redirect(route('services.index'));
    }
}