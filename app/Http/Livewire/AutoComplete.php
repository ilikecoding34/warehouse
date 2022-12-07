<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Type;
use Str;

class AutoComplete extends Component
{

    public $types;
    public $listvisible = false;
    public $typename = '';

    public function mount()
    {
        $this->types = Type::all();
    }
    public function typeSelected($typename)
    {
        $this->typename = $typename;
    }

    public function render()
    {
        if(Str::length($this->typename) > 3 && count($this->types) > 1){
            $this->listvisible = true;
            $this->types = Type::where('name', 'like', $this->typename.'%')->get();
        }else{
            $this->listvisible = false;
        }

        return view('livewire.auto-complete');
    }
}
