<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodolistController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view("home.todolist", [
            "title" => "Todolist",
            "todos" => $todos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "task" => "required|string|max:255",
        ]);

        Todo::create(["task" => $request->task]);

        return redirect()->route("todolist.index")->with("success", "Todo added successfully!");
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->route("todolist.index")->with("success", "Todo removed successfully!");
    }

    public function complete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update(["completed" => true]);

        return redirect()->route("todolist.index")->with("success", "Todo marked as completed!");
    }
}
