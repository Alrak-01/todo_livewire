<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Todo as TodoModel;

class Todo extends Component
{   
    #[Rule("required|string|max:100")]
    public $name;

    public function create(){
        $validated = $this->validateOnly("name");

        TodoModel::create($validated);
        $this->reset("name");
        session()->flash('success', "Todo created");

    }

    public function render()
    {
        return view('livewire.todo');
    }
}
