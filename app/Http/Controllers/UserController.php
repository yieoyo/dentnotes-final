<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    public function create()
    {
        if (auth()->user->isAdmin()) {
            $roles = Role::withoutTrashed()->get();
            return view('user.create', compact('roles'));
        }
        abort(403, 'Unauthorized action.');
    }


    public function store(UserRequest $request)
    {
        if (auth()->user->isAdmin()) {
            $newUser = User::create(['name' => $request->input('name'), 'email' => $request->input('email'), 'password' => bcrypt($request->input('password')), 'role_id' => $request->input('role'), 'status' => $request->input('status'),]);
            if ($newUser) {
                if ($request->hasFile('avatar')) {
                    $image = $request->file('avatar');

                    // Generate a unique filename using the original file extension
                    $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

                    // Move the file to the desired location
                    $image->move(public_path(config('panel.avatar_path')), $image_name);

                    $newUser->update(['avatar' => $image_name != null ? config('panel.avatar_path') . $image_name : config('panel.avatar')]);
                }
                return redirect()->route('user.index')->with('success', 'User created successfully');
            }
            return redirect()->route('user.index')->with('error', 'Failed to create user.');
        }
        abort(403, 'Unauthorized action.');
    }

    public function edit(int $userId)
    {
        $user = User::findOrFail($userId);
        if (auth()->user()->isAdmin()) {
            $roles = Role::withoutTrashed()->get();
            return view('user.edit', compact('user', 'roles'));
        } elseif (auth()->user()->id == $userId) {
            return view('user.edit', compact('user'));
        }
        abort(403, 'Unauthorized action.');
    }

    public function update(UserUpdateRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        if ((auth()->user()->id == $user->id || auth()->user()->isSuperAdmin || auth()->user()->isAdmin()) && $user->id != config('panel.super_admin')) {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                if ($user->avatar != config('panel.avatar')) {
                    unlink(public_path($user->avatar));
                }
                // Generate a unique filename using the original file extension
                $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

                // Move the file to the desired location
                $image->move(public_path(config('panel.avatar_path')), $image_name);
            }
            $user->update(['name' => $request->input('name'), 'role_id' => auth()->user()->isAdmin() ? $request->input('role') : auth()->user()->role->id, 'status' => auth()->user()->isAdmin() ? $request->input('status') : auth()->user()->status, 'avatar' => isset($image_name) ? config('panel.avatar_path') . $image_name : $user->avatar,]);

            return redirect()->route('user.view', auth()->user()->id)->with('success', 'User updated successfully');
        }
        abort(403, 'Unauthorized action.');
    }

    public function view($userId)
    {
        $user = User::findOrFail($userId);
        if (auth()->user()->id == $userId) {
            return view('user.view', compact('user'));
        } elseif (auth()->user()->isAdmin()) {
            return view('user.view', compact('user'));
        }
        abort(403, 'Unauthorized action.');
    }

    public function retrieveDleted($userId)
    {
        if (auth()->user->isAdmin()) {
            if (User::withTrashed()->findOrFail($userId)->restore()) {
                return redirect()->route('user.index')->with('success', 'User retrieved successfully');
            }
            return redirect()->back()->with('error', 'User can not retrieved');
        }
        abort(403, 'Unauthorized action.');
    }

    public function destroy($userId)
    {
        if (auth()->user->isAdmin()) {
            if (User::findOrFail($userId)->delete()) {
                return redirect()->route('user.index')->with('success', 'User deleted successfully');
            }
            return redirect()->back()->with('error', 'Failed to delete.');
        }
        abort(403, 'Unauthorized action.');
    }

    public function changeUserPassword(Request $request, $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        if ((auth()->user()->id == $user->id || auth()->user()->isSuperAdmin() || auth()->user()->isAdmin()) && $user->id != config('panel.super_admin')) {
            // Validate the request
            $request->validate(['password' => 'required|min:6|confirmed',]);

            // Find the user
            $user = User::findOrFail($userId);

            // Update user's password
            $user->update(['password' => bcrypt($request->password)]);

            // Redirect back or show a success message
            return redirect()->route('user.view', auth()->user()->id)->with('success', 'Password changed successfully.');
        }
        abort(403, 'Unauthorized action.');
    }

    public function forceDelete($userId)
    {
        if (auth()->user->isAdmin()) {
            $user = User::onlyTrashed()->findOrFail($userId);
            $avatar = $user->avatar;
            if ($user->forceDelete()) {
                if ($avatar != config('panel.avatar')) {
                    unlink(public_path($avatar));
                }
                return redirect()->route('user.index')->with('success', 'User deleted successfully!');
            }
            return redirect()->route('user.index')->with('error', 'User can not be force deleted');
        }
        abort(403, 'Unauthorized action.');
    }
}
