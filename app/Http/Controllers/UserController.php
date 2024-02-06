<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    public function create()
    {
        $roles = Role::withoutTrashed()->get();
        return view('user.create', compact('roles'));
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

    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('user.view', compact('user'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function edit(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::withoutTrashed()->get();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $image_name = null;
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            if($user->avatar != config('panel.avatar')){
                dd(file_exists($user->avatar));
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

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
