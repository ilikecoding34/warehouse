<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Type;
use Str;

class AutoComplete extends Component
{

    public $types;
    public $listvisible = false;
    public $multiplelistvisible = false;
    public $typename, $typesearchname = '';

    public $typemultiplename = [];
    public $typearray = [];
    public $typeselected = [];

    public $inputlength = 0;

    public $multilistshow = true;

    public function mount()
    {
        $this->types = Type::all();
    }
    public function typeSelected($typename)
    {
        $this->typename = $typename;
    }

    public function typeMultiSelect($typename)
    {
        array_push($this->typemultiplename, $typename);
        $this->typeselected = [];
        foreach ($this->typemultiplename as $key => $value) {
            array_push($this->typeselected, ['name', '<>', $value]);
        }
    }

    public function showhidelist()
    {
        $this->multilistshow = false;
        $this->inputlength = Str::length($this->typesearchname);
    }

    public function render()
    {
        if(Str::length($this->typename) > 2 && count($this->types) > 1){
            $this->listvisible = true;
            $this->types = Type::where('name', 'like', $this->typename.'%')->get();
        }else{
            $this->listvisible = false;
        }

        if($this->inputlength != Str::length($this->typesearchname)){
            $this->multilistshow = true;
        }

        if(Str::length($this->typesearchname) > 2 && count($this->types) > 0){

            if($this->multilistshow){
                $this->multiplelistvisible = true;
            }else{
                $this->multiplelistvisible = false;
            }

            if(count($this->typeselected)>0){
                $this->types = Type::where('name', 'like', $this->typesearchname.'%')->where($this->typeselected)->get();
            }else{
                $this->types = Type::where('name', 'like', $this->typesearchname.'%')->get();
            }
            
        }else{
            $this->multiplelistvisible = false;
        }
        
        return view('livewire.auto-complete');
    }
}
