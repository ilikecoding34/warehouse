<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;

class DataTables extends Component
{
    public $items;
    public $sortedfield;
    public $serialnumber = '';
    public $uname = '';
   // public $allfilter = [];

    public $direction = 'asc';
    public function mount()
    {
        $this->items = Item::all();
    }

    public function sortBy($field)
    {
        $this->sortedfield == $field ? $this->direction = $this->direction == 'asc' ? 'desc' : 'asc' : $this->direction = 'desc';
        $this->sortedfield = $field;
        
        $this->items = Item::orderBy($field, $this->direction)->get();
    }
    public function render()
    {
        $allfilter = [];
        if($this->serialnumber != ''){
            $serialfilter = ['serialnumber', 'like', $this->serialnumber."%"];
            array_push($allfilter, $serialfilter);
        }
        if($this->uname != ''){
            $uniquefilter = ['uniquename', 'like', $this->uname."%"];
            array_push($allfilter, $uniquefilter);
        }

        if(count($allfilter)>0){
            $this->items = Item::where($allfilter)->get();
        }else{
            $this->items = Item::all();
        }
        
        return view('livewire.data-tables', ['items' => $this->items])->layout('layouts.app');
    }
}
