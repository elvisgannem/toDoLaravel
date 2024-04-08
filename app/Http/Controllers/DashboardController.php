<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return \view('dashboard', [
            'users' => User::whereNot('id', auth()->user()->id)->get()
        ]);
    }

    public function makeAdmin(int $userId): RedirectResponse
    {
        User::where('id', $userId)->update(['isAdmin' => true]);

        return redirect()->back()->with('success', 'Usuário alterado com sucesso');
    }

    public function deleteUser(int $userId): RedirectResponse
    {
        User::where('id', $userId)->delete();

        return redirect()->back()->with('success', 'Usuário deletado com sucesso');
    }
}
