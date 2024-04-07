<?php

namespace App\Http\Controllers;

use App\Models\Task;
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

    public function store()
    {

    }
}
