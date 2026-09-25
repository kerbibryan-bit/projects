<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Display all tasks
    public function index()
    {
        $tasks = Task::latest()->get();

        return view('index', compact('tasks'));
    }

    // Show Add Task form
   public function create()
   {
    return view('create');
   }

    // Save new task
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task added successfully!');
    }

    // Show Edit form
    public function edit(Task $task)
    {
    return view('edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    // Delete task
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    // Change task status
    public function status(Task $task)
    {
        if ($task->status == 'Pending') {
            $task->status = 'Completed';
        } else {
            $task->status = 'Pending';
        }

        $task->save();

        return redirect()->route('tasks.index');
    }
}