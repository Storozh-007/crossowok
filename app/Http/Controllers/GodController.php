<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GodController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->get();

        return view('god.panel', compact('users'));
    }

    public function setAdmin(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->role = $request->role; // admin / user
        $user->save();

        return back()->with('success', 'Role updated successfully.');
    }
}
