<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Todo as TodoModel;
use Livewire\WithPagination;

class Todo extends Component
{   
    
    use WithPagination;

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
        $todos = TodoModel::orderBy("created_at", "desc")->paginate(5);
        return view('livewire.todo', ["todos" => $todos]);
    }
}
