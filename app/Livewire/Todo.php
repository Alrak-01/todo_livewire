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

    public $editTodoId;

    #[Rule("required|string|max:100")]
    public $editNewName;

   

    public function create(){
        $validated = $this->validateOnly("name");

        TodoModel::create($validated);
        $this->reset("name");
        session()->flash('success', "Todo created");

        $this->resetPage();

    }

     public function edit($todoId){
        $this->editTodoId = $todoId;

        $todo = TodoModel::findOrFail($todoId);
        $this->editNewName = $todo['name'];
    }

    public function cancle(){
        $this->reset(["editNewName", "editTodoId"]);
    }
    
    public function update($todoId){
        $todo = TodoModel::findOrFail($todoId);
        
        $this->validateOnly("editNewName");

        $todo->update([
            "name" => $this->editNewName,
        ]);

        $this->cancle();

    }

    public function destroy($todoId){
        $todo = TodoModel::findOrFail($todoId);
        $todo->delete();
    }

    public function render()
    {
        $todos = TodoModel::orderBy("created_at", "desc")->where("name", "like", "%" . $this->search . "%")->paginate(5);

        return view('livewire.todo', ["todos" => $todos]);
    }
}
