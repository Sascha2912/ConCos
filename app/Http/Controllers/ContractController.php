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
        $contracts = Contract::paginate(10);

        return view('contracts.index', ['contracts' => $contracts]);
    }

    /**
     * Show the forms for creating a new resource.
     */
    public function create() {

        // Lade die benötigten Services und andere Daten für die Komponente
        $services = Service::all();

        // Übergib die Daten an die Blade-View, die die Livewire-Komponente einbindet
        return view('contracts.create', ['services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, Contract::validationRules(true));
        $contract = $this->contractRepository->updateOrCreate($data);

        // Füge die Services zum Vertrag hinzu
        foreach($request->input('services') as $serviceId => $serviceData){
            $contract->services()->attach($serviceId, ['hours' => $serviceData['hours']]);
        }

        if($request->expectsJson()){

            return response([
                'contract' => $contract,
                'success'  => true,
            ]);
        }

        return redirect(route('contracts.edit', ['contract' => $contract]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Contract $contract) {
        $services = $contract->services()->withPivot('hours')->get();
        $availableServices = Service::whereNotIn('id', $services->pluck('id'))->get();

        if($request->expectsJson()){

            return response([
                'contract'          => $contract,
                'services'          => $services,
                'availableServices' => $availableServices,
            ]);
        }

        return view('contracts.edit',
            [
                'contract'          => $contract,
                'services'          => $services,
                'availableServices' => $availableServices,
            ]);
    }

    /**
     * Show the forms for editing the specified resource.
     */
    public function edit(Contract $contract) {
        $services = $contract->services()->withPivot('hours')->get();
        $availableServices = Service::whereNotIn('id', $services->pluck('id'))->get();

        return view('contracts.edit',
            [
                'contract'          => $contract,
                'services'          => $services,
                'availableServices' => $availableServices,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract) {
        $data = $this->validate($request, Contract::validationRules());
        $contract = $this->contractRepository->updateOrCreate($data, $contract);

        // Synchronisiere die Services und Stunden
        $this->syncServices($contract, $request->input('services', []));

        if($request->expectsJson()){

            return response([
                'success'  => true,
                'contract' => $contract,
            ]);
        }

        return redirect()->route('contracts.edit', $contract)->with('success', 'Contract updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract) {
        $contract->delete();

        return redirect(route('contracts.index'));
    }

    protected function syncServices(Contract $contract, array $services) {
        $servicesWithHours = [];
        foreach($services as $serviceId => $data){
            $servicesWithHours[$serviceId] = ['hours' => (int) $data['hours']];
        }
        $contract->services()->sync($servicesWithHours);
    }
}