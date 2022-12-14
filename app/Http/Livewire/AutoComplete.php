<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Category;
use Str;

class AutoComplete extends Component
{
    public $modeldata;
    public $item_id;
    public $single, $model, $inputname, $title;
    public $listvisible,$multiplelistvisible = false;
    public $singleSearchInput, $multipleSearchInput,$singleSelectedvalue = '';
    public $multipleSelected = [], $multipleSelectedids = [], $categoryarray = [], $filterarray = [];

    public function mount()
    {
        $item = Item::find($this->item_id);
        $this->modeldata = $this->model::all();
        $this->singleSelectedvalue = $item->company;
        $categories = $item->categories()->get();
        $this->multipleSelected = $categories->pluck('name')->toArray();
        $this->multipleSelectedids = $categories->pluck('id')->toArray();
    }
    public function singleSelect($inputdata)
    {
        $this->singleSelectedvalue = $inputdata;
    }

    public function multipleSelect($inputid, $inputdata)
    {
        $indexOfSelected = $this->modeldata->pluck('name')->search($inputdata);
        $this->modeldata->splice($indexOfSelected, 1);
        if(!in_array($inputid, $this->multipleSelectedids)){
            array_push($this->multipleSelected, $inputdata);
            array_push($this->multipleSelectedids, $inputid);
            $this->filterarray = [];
            foreach ($this->multipleSelected as $key => $value) {
                array_push($this->filterarray, ['name', '<>', $value]);
            }
        }
    }

    public function removeFromList($indexnumber)
    {
        unset($this->multipleSelected[$indexnumber]);
        unset($this->multipleSelectedids[$indexnumber]);
        unset($this->filterarray[$indexnumber]);
        $this->multipleSelected = array_values($this->multipleSelected);
        $this->multipleSelectedids = array_values($this->multipleSelectedids);
        $this->filterarray = array_values($this->filterarray);
    }

    public function clearAllSelected()
    {
        $this->multipleSelected = [];
        $this->multipleSelectedids = [];
        $this->filterarray = [];
    }

    public function showhidelist()
    {
        $this->multiplelistvisible = false;
        $this->listvisible = false;
    }

    public function searchInTable($single)
    {
        if($single){
            if(Str::length($this->singleSearchInput) > 2){
                $this->modeldata = $this->model::where('name', 'like', $this->singleSearchInput.'%')->get();
            }
            
            if(count($this->modeldata) > 0){
                $this->listvisible = true;
            }else{
                $this->listvisible = false;
            }
        }else{
            if(Str::length($this->multipleSearchInput) > 2){
                if(count($this->filterarray)>0){
                    $this->modeldata = $this->model::where('name', 'like', $this->multipleSearchInput.'%')->where($this->filterarray)->get();
                }else{
                    $this->modeldata = $this->model::where('name', 'like', $this->multipleSearchInput.'%')->get();
                }
            }
            
            if(count($this->modeldata) > 0){
                $this->multiplelistvisible = true;
            }else{
                $this->multiplelistvisible = false;
            }
        }
    }

    public function render()
    {
        
        return view('livewire.auto-complete');
    }
}
