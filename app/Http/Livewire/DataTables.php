<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Quantity;
use DB;

class DataTables extends Component
{
    public $items;
    public $sortedfield = 'id';
    public $serialnumber, $uname, $price, $location, $company, $description = '';
    public $totalquantity, $totalvalue = 0;
    public $direction = 'asc';
    public $quantity_value = '';

    public function mount()
    {
        $this->items = Item::all();
    }

    public function sortBy($field)
    {
        $this->sortedfield == $field ? $this->direction = $this->direction == 'asc' ? 'desc' : 'asc' : $this->direction = 'desc';
        $this->sortedfield = $field;
        $this->searchInTable();
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
            'price' => $this->price,
            'location' => $this->location,
            'company' => $this->company,
            'description' => $this->description
        ];

        $allfilter = $this->addWhereClosure($columns);

        if($this->quantity_value != ''){
            $par = $this->quantity_value;
            $this->items = Item::whereIn('id', function($query) use($par){
                $query->select('item_id')->from('quantities')->whereIn('id', function($query) use($par){
                    $query->select(DB::raw('MAX(id) as id'))->from('quantities')->groupBy('item_id');
                })->where('value', '>', $par);
            })->where($allfilter)->orderBy($this->sortedfield, $this->direction)->get();

        }else{
            if(count($allfilter)>0){
                $this->items = Item::where($allfilter)->orderBy($this->sortedfield, $this->direction)->get();
            }else{
                $this->items = Item::orderBy($this->sortedfield, $this->direction)->get();
            }
        }
    }

    public function render()
    {

        $this->totalquantity = 0;
        $this->totalvalue = 0;

        foreach ($this->items as $item) {
            $this->totalquantity += $item->quantity_value;
            $this->totalvalue += $item->price*$item->quantity_value;
        }

        return view('livewire.data-tables', ['items' => $this->items])->layout('layouts.app');
    }
}
