<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueryController extends Controller
{
    //
    public function index()
    {
        return view('query.index');
    }

    public function store(UserRequest $request)
    {
        $image_name = null;
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');

            // Generate a unique filename using the original file extension
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

            // Move the file to the desired location
            $image->move(public_path(config('panel.avatar_path')), $image_name);
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => $request->input('role'),
            'status' => $request->input('status'),
            'avatar' => $image_name != null ? config('panel.avatar_path') . $image_name : config('panel.avatar'),
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function create()
    {
        $roles = Role::withoutTrashed()->get();
        return view('user.create', compact('roles'));
    }

    public function view($userId)
    {
        $user = User::findOrFail($userId);
        return view('user.view', compact('user'));
    }

    public function edit(Request $request, int $userId)
    {
        $user = User::findOrFail($userId);
        return view('user.edit', compact('user'));
    }

    public function destroy($userId)
    {
        User::findOrFail($userId)->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
