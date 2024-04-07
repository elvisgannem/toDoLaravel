<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TasksController extends Controller
{
    public function index(): View
    {
        $tasks = Task::with('relator')->get();

        return view('todolist', [
            'tasks' => $tasks,
        ]);
    }

    public function store(CreateTaskRequest $request): RedirectResponse
    {
        Task::create([
            'name' => $request->taskName,
            'description' => $request->description,
            'relator_user_id' => Auth::user()->id,
            'finished' => false,
        ]);

        return redirect()->back()->with('success', 'Tarefa criada com sucesso');
    }

    public function destroy(int $id): RedirectResponse
    {
        Task::find($id)->delete();
        return redirect()->back()->with('success', 'Tarefa deletada com sucesso');
    }
}
