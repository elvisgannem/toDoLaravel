<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
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

    public function edit(int $id): View
    {
        return view('todolist-edit', [
            'task' => Task::find($id),
            'users' => User::all(),
        ]);
    }

    public function addUsers(int $id): View
    {
        return view('todolist-users', [
            'users' => User::all(),
            'taskId' => $id,
        ]);
    }

    public function update(UpdateTaskRequest $request): RedirectResponse
    {
        $task = Task::findOrFail($request->id);

        $taskData = [];

        if ($request->filled('taskName')) {
            $taskData['name'] = $request->taskName;
        }

        if ($request->filled('taskDescription')) {
            $taskData['description'] = $request->taskDescription;
        }

        if ($request->filled('finished')) {
            $taskData['finished'] = $request->finished;
        }

        if (!$taskData) {
            return redirect()->back()->withErrors(['Não foi enviado nenhum valor para ser atualizado']);
        }

        $task->update($taskData);

        return redirect()->route('todolist.index')->with('success', 'Tarefa atualizada com sucesso');
    }

    public function destroy(int $id): RedirectResponse
    {
        Task::find($id)->delete();

        return redirect()->back()->with('success', 'Tarefa deletada com sucesso');
    }
}
