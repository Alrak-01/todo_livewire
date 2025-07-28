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

    public $search;

    public function create(){
        $validated = $this->validateOnly("name");

        TodoModel::create($validated);
        $this->reset("name");
        session()->flash('success', "Todo created");

    }

    public function render()
    {
        // $todos = TodoModel::latest()->where("name", "like", '%' . $this->search . '%')->paginate(5);
        $todos = TodoModel::orderBy("created_at", "desc")->where("name", "like", "%" . $this->search . "%")->paginate(5);

        return view('livewire.todo', ["todos" => $todos]);
    }
}
