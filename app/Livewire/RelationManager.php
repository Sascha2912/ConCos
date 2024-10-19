<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class RelationManager extends Component {

    public $model;
    public $relatedModel;
    public $relatedItems = [];
    public $availableItems;
    public $selectedItemId = null;

    public function mount($model, $relatedModel) {
        $this->model = $model;
        $this->relatedItems = $model->{$relatedModel}->toArray(); // Lädt die bestehenden Beziehungen
        $this->availableItems = $this->getAvailableItems();
    }

    public function getAvailableItems() {
        $relatedClass = "App\\Models\\".ucfirst(Str::singular($this->relatedModel));

        return $relatedClass::whereNotIn('id', array_column($this->relatedItems, 'id'))->get();
    }

    public function addRelation($itemId) {
        $relatedClass = "App\\Models\\".ucfirst(Str::singular($this->relatedModel));
        $item = $relatedClass::find($itemId);

        if($item && !in_array($itemId, array_column($this->relatedItems, 'id'))){
            $this->relatedItems[] = $item->toArray();
            $this->availableItems = $this->availableItems->filter(fn($i) => $i->id != $itemId);
            $this->reset('selectedItemId');
        }
    }

    public function removeRelation($itemId) {
        $this->relatedItems = array_filter($this->relatedItems, fn($i) => $i['id'] != $itemId);

        $relatedClass = "App\\Models\\".ucfirst(Str::singular($this->relatedModel));
        $item = $relatedClass::find($itemId);

        if($item && !$this->availableItems->contains('id', $itemId)){
            $this->availableItems->push($item);
        }
    }

    public function saveRelations() {
        $relatedIds = array_column($this->relatedItems, 'id');
        $this->model->{$this->relatedModel}()->sync($relatedIds);
        session()->flash('message', ucfirst(Str::singular($this->relatedModel)).' relations updated successfully.');
    }

    public function render() {
        return view('livewire.relation-manager');
    }
}
