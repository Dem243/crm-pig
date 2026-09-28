<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();
        $roles = Role::orderBy('nom')->get();

        return view('utilisateurs.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre role.');
        }

        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->role_id = $validated['role_id'];
        $user->save();

        return back()->with('success', "Role de {$user->name} mis a jour.");
    }
}