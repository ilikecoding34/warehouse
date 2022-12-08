<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Quantity;

class DataTables extends Component
{
    public $items;
    public $sortedfield = 'id';
    public $serialnumber, $uname, $price, $location, $company, $description = '';
    public $totalquantity, $totalvalue = 0;
    public $direction = 'asc';
    public $quantity_value = '20';

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

    public function orderBy($field)
    {
        $this->sortedfield == $field ? $this->direction = $this->direction == 'asc' ? 'desc' : 'asc' : $this->direction = 'desc';
        $this->sortedfield = $field;
        $this->items = $this->direction == 'asc' ? $this->items->sortByDesc($field) : $this->items->sortBy($field);
    }

    public function addWhereClosure($columns)
    {
        $allfilter = [];
        foreach ($columns as $key => $value) {
            if($value != ''){
                array_push($allfilter, [$key, 'like', $value."%"]);
            }
        }
        return $allfilter;
    }

    public function searchInTable()
    {
        $columns = [
            'serialnumber' => $this->serialnumber,
            'uniquename' => $this->uname,
            'quantity_value' => $this->quantity_value,
            'price' => $this->price,
            'location' => $this->location,
            'company' => $this->company,
            'description' => $this->description
        ];

        $allfilter = $this->addWhereClosure($columns);

        if(count($allfilter)>0){
        //    $this->items = Item::where($allfilter)->orderBy($this->sortedfield, $this->direction)->get();
        }else{
        //    $this->items = Item::orderBy($this->sortedfield, $this->direction)->get();
        }
    }

    public function render()
    {


        $this->searchInTable();

        $this->totalquantity = 0;
        $this->totalvalue = 0;

        foreach ($this->items as $item) {
            $this->totalquantity += $item->quantity_value;
            $this->totalvalue += $item->price*$item->quantity_value;
        }

         $qu = Quantity::where('value', '>', $this->quantity_value)->latest()->pluck('item_id');
         $this->items = Item::whereIn('id', $qu)->get();

        return view('livewire.data-tables', ['items' => $this->items])->layout('layouts.app');
    }
}
