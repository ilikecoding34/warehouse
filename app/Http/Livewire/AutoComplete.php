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

    public $inputlength = 0;

    public $multilistshow = true;

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
        $this->multilistshow = false;
        $this->inputlength = Str::length($this->categorysearchname);
    }

    public function render()
    {
        if(Str::length($this->categoryname) > 2 && count($this->categories) > 1){
            $this->listvisible = true;
            $this->categories = Category::where('name', 'like', $this->categoryname.'%')->get();
        }else{
            $this->listvisible = false;
        }

        if($this->inputlength != Str::length($this->categorysearchname)){
            $this->multilistshow = true;
        }

        if(Str::length($this->categorysearchname) > 2 && count($this->categories) > 0){

            if($this->multilistshow){
                $this->multiplelistvisible = true;
            }else{
                $this->multiplelistvisible = false;
            }

            if(count($this->categoryselected)>0){
                $this->categories = Category::where('name', 'like', $this->categorysearchname.'%')->where($this->categoryselected)->get();
            }else{
                $this->categories = Category::where('name', 'like', $this->categorysearchname.'%')->get();
            }

        }else{
            $this->multiplelistvisible = false;
        }

        return view('livewire.auto-complete');
    }
}
