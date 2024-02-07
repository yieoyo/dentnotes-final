<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
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
        $roles = Role::withoutTrashed()->get();
        return view('user.edit', compact('user', 'roles'));
    }

    public function destroy($userId)
    {
        User::findOrFail($userId)->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function changeUserPassword(Request $request, $userId): \Illuminate\Http\RedirectResponse
    {
        // Validate the request
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        // Find the user
        $user = User::findOrFail($userId);

        // Update user's password
        $user->update(['password' => bcrypt($request->password)]);


        // Redirect back or show a success message
        return redirect()->route('user.view', $userId)->with('success', 'Password changed successfully.');
    }

    public function update(UserUpdateRequest $request, $userId): \Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail($userId);
        $image_name = null;
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            if ($user->avatar != config('panel.avatar')) {
                unlink($user->avatar);
            }
            // Generate a unique filename using the original file extension
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

            // Move the file to the desired location
            $image->move(public_path(config('panel.avatar_path')), $image_name);
        }
        $user->update([
            'name' => $request->input('name'),
            'role_id' => $request->input('role'),
            'status' => $request->input('status'),
            'avatar' => $image_name != null ? config('panel.avatar_path') . $image_name : $user->avatar,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
}
