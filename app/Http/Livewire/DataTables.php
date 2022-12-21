<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use App\Models\Item;
use DB;

class DataTables extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['serialnumber', 'uname', 'price', 'location', 'company', 'description'];
    protected $items;

    public $sortedfield = 'id';
    public $serialnumber, $uname, $price, $location, $company, $description;
    public $totalquantity = 0, $totalvalue = 0, $relation = 0;
    public $fieldDirection = 'asc';
    public $quantity_value = '';

    public function mount()
    {
        $this->searchInTable();
    }

    public function sortBy($field)
    {
        $this->sortedfield == $field ? $this->fieldDirection = $this->fieldDirection == 'asc' ? 'desc' : 'asc' : $this->fieldDirection = 'desc';
        $this->sortedfield = $field;
        $this->resetPage();
        $this->searchInTable();
    }

    public function orderBy($field)
    {
        $this->sortedfield == $field ? $this->fieldDirection = $this->fieldDirection == 'asc' ? 'desc' : 'asc' : $this->fieldDirection = 'desc';
        $this->sortedfield = $field;
        $this->items = $this->fieldDirection == 'asc' ? $this->items->sortByDesc($field) : $this->items->sortBy($field);
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

    public function filterChanged()
    {
        $this->resetPage();
        $this->searchInTable();
    }

    public function calculateSumValues($inputCollection)
    {
        $items = $inputCollection->get();
        $sumvalue = 0;
        $sumquantity = 0;
        
        foreach ($items as $key => $value) {
            $sumquantity += $value->getLatestQuantity->value;
            $sumvalue += $value->getLatestQuantity->value * $value->price;
        }
        $this->totalquantity = $sumquantity;
        $this->totalvalue = $sumvalue;

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
            $rel = '';
            $par = $this->quantity_value;
            switch ($this->relation) {
                case 0:
                    $rel = 'Like';
                    if(!str_contains($par, '%')){
                        $par = $par.'%';
                    }
                    break;
                case 1:
                    $rel = '>';
                    if(str_contains($par, '%')){
                        $par = substr($par, 0, -1);
                    }
                    break;
                case 2:
                    $rel = '<';
                    if(str_contains($par, '%')){
                        $par = substr($par, 0, -1);
                    }
                    break;
                case 3:
                    $rel = '=';
                    if(str_contains($par, '%')){
                        $par = substr($par, 0, -1);
                    }
                    break;
                default:
                    # code...
                    break;
            }

            $items = Item::whereIn('id', function($query) use($par, $rel){
                $query->select('item_id')->from('quantities')->whereIn('id', function($query) use($par){
                    $query->select(DB::raw('MAX(id) as id'))->from('quantities')->groupBy('item_id');
                })->where('value', $rel, $par);
            })->where($allfilter)->orderBy($this->sortedfield, $this->fieldDirection)->with('getLatestQuantity');

        }else{
            if(count($allfilter)>0){
                $items = Item::where($allfilter)->orderBy($this->sortedfield, $this->fieldDirection)->with('getLatestQuantity');
            }else{
                $items = Item::orderBy($this->sortedfield, $this->fieldDirection)->with('getLatestQuantity');
            }
        }
        $this->calculateSumValues($items);
        return $items;
    }

    public function render()
    {
        return view('livewire.data-tables', ['items' => $this->searchInTable()->paginate(50)])->layout('layouts.app');
    }
}
