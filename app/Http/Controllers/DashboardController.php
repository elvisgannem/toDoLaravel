<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return \view('dashboard', [
            'users' => User::where('isAdmin', false)->get()
        ]);
    }
}
