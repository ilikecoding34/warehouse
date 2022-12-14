<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;
use Str;

class SingleSelectAutocomplete extends Component
{
    public $modeldata;
    public $item_id;
    public $single, $model, $inputname, $title;
    public $listvisible = false;
    public $singleSearchInput,$singleSelectedvalue = '';

    public function mount()
    {
        if(isset($this->item_id)){
            $item = Item::find($this->item_id);
            $this->singleSelectedvalue = $item->company;
        }
        $this->modeldata = $this->model::all();
    }
    public function singleSelect($inputdata)
    {
        $this->singleSelectedvalue = $inputdata;
    }

    public function showhidelist()
    {
        $this->listvisible = false;
    }

    public function searchInTable()
    {
        if(Str::length($this->singleSearchInput) > 2){
            $this->modeldata = $this->model::where('name', 'like', $this->singleSearchInput.'%')->get();
        }
        
        if(count($this->modeldata) > 0){
            $this->listvisible = true;
        }else{
            $this->listvisible = false;
        }
    }

    public function render()
    {
        return view('livewire.single-select-autocomplete');
    }
}
