<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use App\Models\Item;
use App\Models\Quantity;
use DB;

class DataTables extends Component
{
    use WithPagination;

    protected $trackComponentPath = '';
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['serialnumber', 'uname', 'price', 'location', 'company', 'description'];
    protected $items;

    public $sortedfield = 'id';
    public $serialnumber, $uname, $price, $location, $company, $description;
    public $totalquantity, $totalvalue, $relation, $resultcount = 0;
    public $direction = 'asc';
    public $quantity_value = '';
    public $currentPage = 1;

    public function mount()
    {
        $this->searchInTable();
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
        $items;
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
            })->where($allfilter)->orderBy($this->sortedfield, $this->direction);

        }else{
            if(count($allfilter)>0){
                $items = Item::where($allfilter)->orderBy($this->sortedfield, $this->direction);
            }else{
                $items = Item::orderBy($this->sortedfield, $this->direction);
            }
        }
        return $items;
    }

    public function render()
    {
        $this->totalquantity = 0;
        $this->totalvalue = 0;

        $this->items = $this->searchInTable();
        $this->resultcount = $this->items->count();
        $this->items = $this->items->paginate(50);
        $this->resetPage();
        
        foreach ($this->items as $item) {
            $this->totalquantity += $item->quantity_value;
            $this->totalvalue += $item->price*$item->quantity_value;
        }

        return view('livewire.data-tables', ['items' => $this->items])->layout('layouts.app');
    }
}
