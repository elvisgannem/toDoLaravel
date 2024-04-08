<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserToTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TasksController extends Controller
{
    public function index(): View
    {
        $orderBy = request()->orderBy ?? 'created_at';
        $tasks = Task::with('relator')->orderBy($orderBy, 'ASC')->get();

        return view('todolist', [
            'tasks' => $tasks,
            'orderBy' => $orderBy
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
        ]);
    }

    public function addUsers(int $id): View
    {
        $usersWithoutTask = DB::table('users')
            ->leftJoin('task_user', function ($join) use ($id) {
                $join->on('users.id', '=', 'task_user.user_id')
                    ->where('task_user.task_id', '=', $id);
            })
            ->whereNull('task_user.task_id')
            ->select('users.*')
            ->get();

        return view('todolist-users', [
            'users' => $usersWithoutTask,
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

        if (! $taskData) {
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

    public function removeUserFromTask(int $id, int $userId): RedirectResponse
    {
        TaskUser::where('task_id', $id)->where('user_id', $userId)->delete();

        return redirect()->back()->with('success', 'Usuário removido com sucesso');
    }

    public function addUserToTask(AddUserToTaskRequest $request): RedirectResponse
    {
        TaskUser::create([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->back()->with('success', 'Usuário adicionado com sucesso');
    }
}
