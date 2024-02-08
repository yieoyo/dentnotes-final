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

    // Display a listing of the resource.
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->isAdmin()) {
            $roles = Role::withoutTrashed()->get(); // Retrieve roles
            return view('user.create', compact('roles')); // Return view with roles data
        }
        abort(403, 'Unauthorized action.'); // If not admin, abort with 403 error
    }

    // Store a newly created resource in storage.
    public function store(UserRequest $request)
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->isAdmin()) {
            // Create new user
            $newUser = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            // If user created successfully
            if ($newUser) {
                // Check if avatar file exists in request
                if ($request->hasFile('avatar')) {
                    $image = $request->file('avatar');

                    // Generate a unique filename using the original file extension
                    $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

                    // Move the file to the desired location
                    $image->move(public_path(config('panel.avatar_path')), $image_name);

                    // Update user avatar
                    $newUser->update(['avatar' => $image_name != null ? config('panel.avatar_path') . $image_name : config('panel.avatar')]);
                }
                return redirect()->route('user.index')->with('success', 'User created successfully');
            }
            return redirect()->route('user.index')->with('error', 'Failed to create user.');
        }
        abort(403, 'Unauthorized action.');
    }

    // Show the form for editing the specified resource.
    public function edit(int $userId)
    {
        // Find the user by ID
        $user = User::findOrFail($userId);

        // Check if the authenticated user is admin or owner of the user being edited
        if (auth()->user()->isAdmin()) {
            $roles = Role::withoutTrashed()->get(); // Retrieve roles
            return view('user.edit', compact('user', 'roles')); // Return view with user and roles data
        } elseif (auth()->user()->id == $userId) {
            return view('user.edit', compact('user')); // Return view with user data
        }
        abort(403, 'Unauthorized action.');
    }

    // Update the specified resource in storage.
    public function update(UserUpdateRequest $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Check if authenticated user is authorized to update the user
        if (auth()->user()->id == $user->id || auth()->user()->isSuperAdmin() || (auth()->user()->isAdmin() &&  $user->isNotSuperAdmin())) {
            // Check if avatar file exists in request
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                if ($user->avatar != config('panel.avatar')) {
                    unlink(public_path($user->avatar)); // Delete old avatar file
                }
                // Generate a unique filename using the original file extension
                $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

                // Move the file to the desired location
                $image->move(public_path(config('panel.avatar_path')), $image_name);
            }
            // Update user data
            $user->update([
                'name' => $request->input('name'),
                'avatar' => isset($image_name) ? config('panel.avatar_path') . $image_name : $user->avatar,
            ]);

            return redirect()->route('user.view', auth()->user()->id)->with('success', 'User updated successfully');
        }
        abort(403, 'Unauthorized action.');
    }

    // Display the specified resource.
    public function view($userId)
    {
        // Find the user by ID
        $user = User::findOrFail($userId);

        // Check if authenticated user is the owner of the requested user or an admin
        if (auth()->user()->id == $userId || auth()->user()->isAdmin()) {
            return view('user.view', compact('user')); // Return view with user data
        }
        abort(403, 'Unauthorized action.');
    }

    // Change the password for the specified user.
    public function changeUserPassword(Request $request, $userId): RedirectResponse
    {
        // Validate the request
        $request->validate(['password' => 'required|min:6|confirmed',]);
        $user = User::findOrFail($userId);
        // Check if authenticated user is authorized to change password for the user
        if (auth()->user()->id == $user->id || auth()->user()->isSuperAdmin() || (auth()->user()->isAdmin() &&  $user->isNotSuperAdmin())) {

            // Update user's password
            $user->update(['password' => bcrypt($request->input('password'))]);

            // Redirect back or show a success message
            return redirect()->route('user.view', auth()->user()->id)->with('success', 'Password changed successfully.');
        }
        abort(403, 'Unauthorized action.');
    }

    // Remove the specified resource from storage.
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        if (auth()->user()->isAdmin() && $user->isNotSuperAdmin() && auth()->user()->id != $user->id) {
            // Delete user
            if ($user->delete()) {
                return redirect()->route('user.index')->with('success', 'User deleted successfully');
            }
            return redirect()->back()->with('error', 'Failed to delete.');
        }
        abort(403, 'Unauthorized action.');
    }

    // Restore the specified soft deleted resource.
    public function retrieveDeleted($userId)
    {
        if (auth()->user()->isAdmin()) {
            // Restore soft deleted user
            if (User::withTrashed()->findOrFail($userId)->restore()) {
                return redirect()->route('user.index')->with('success', 'User retrieved successfully');
            }
            return redirect()->back()->with('error', 'User can not retrieved');
        }
        abort(403, 'Unauthorized action.');
    }

    // Permanently remove the specified resource from storage.
    public function forceDelete($userId)
    {

        // Find soft deleted user
        $user = User::onlyTrashed()->findOrFail($userId);
        if (auth()->user()->isAdmin() && $user->isNotSuperAdmin()  && auth()->user()->id != $user->id) {
            $avatar = $user->avatar;
            // Permanently delete user
            if ($user->forceDelete()) {
                // If user had an avatar, delete its file
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
