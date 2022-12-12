<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Str;

class AutoComplete extends Component
{

    public $categories;
    public $listvisible = false;
    public $multiplelistvisible = false;
    public $categoryname, $categorysearchname = '';

    public $categorymultiplename = [];
    public $categoryarray = [];
    public $categoryselected = [];
    public $categorysingleselected = '';

    public function mount()
    {
        $this->categories = Category::all();
    }
    public function categoryselected($categoryname)
    {
        $this->categorysingleselected = $categoryname;
    }

    public function categoryMultiSelect($categoryname)
    {
        array_push($this->categorymultiplename, $categoryname);
        $this->categoryselected = [];
        foreach ($this->categorymultiplename as $key => $value) {
            array_push($this->categoryselected, ['name', '<>', $value]);
        }
    }

    public function showhidelist()
    {
        $this->multiplelistvisible = false;
        $this->listvisible = false;
    }

    public function searchInTable($single)
    {
        if($single){
            if(Str::length($this->categoryname) > 2 && count($this->categories) > 1){
                $this->listvisible = true;
                $this->categories = Category::where('name', 'like', $this->categoryname.'%')->get();
            }else{
                $this->listvisible = false;
            }
        }else{
            if(Str::length($this->categorysearchname) > 2 && count($this->categories) > 0){

                $this->multiplelistvisible = true;
    
                if(count($this->categoryselected)>0){
                    dd(Category::where('name', 'like', $this->categorysearchname.'%')->where($this->categoryselected)->toSql());
                    $this->categories = Category::where('name', 'like', $this->categorysearchname.'%')->where($this->categoryselected)->get();
                }else{
                    $this->categories = Category::where('name', 'like', $this->categorysearchname.'%')->get();
                }
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
