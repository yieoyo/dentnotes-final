<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('role.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles']);
        if (auth()->user()->isAdmin()) {
            if (Role::create(['name' => $request->input('name')])) {
                return redirect()->route('role.index')->with('success', 'Role created.');
            }
            return redirect()->route('role.index')->with('error', 'Unable to create role');
        }
        abort(403, 'Unauthorized action');
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            return view('role.create');
        }
        abort(403, 'Unauthorized action');
    }

    public function edit(int $roleId)
    {
        $role = Role::findOrFail($roleId);
        if (auth()->user()->isAdmin() && $role->id != auth()->user()->role->id && !$role->nonRemovableRole()) {
            return view('role.edit', compact('role'));
        }
        abort(403, 'Unauthorized action');
    }

    public function update(Request $request, int $roleId)
    {
        $request->validate(['name' => 'required|string|unique:roles']);

        $role = Role::findOrFail($roleId);
        if (auth()->user()->isAdmin() && $role->id != auth()->user()->role->id && !$role->nonRemovableRole()) {
            if ($role->update(['name' => $request->input('name')])) {
                return redirect()->route('role.index')->with('success', 'Role updated.');
            }
            return redirect()->route('role.index')->with('error', 'Unable to update role');
        }
        abort(403, 'Unauthorized action');
    }

    // Remove the specified resource from storage.
    public function destroy($roleId)
    {
        $role = Role::findOrFail($roleId);
        if (auth()->user()->isAdmin() && !$role->nonRemovableRole()) {
            // Delete role
            if ($role->delete()) {
                return redirect()->route('role.index')->with('success', 'Role deleted successfully');
            }
            return redirect()->back()->with('error', 'Failed to delete.');
        }
        abort(403, 'Unauthorized action.');
    }

    // Restore the specified soft deleted resource.
    public function retrieveDeleted($roleId)
    {
        if (auth()->user()->isAdmin()) {
            // Restore soft deleted role
            if (Role::withTrashed()->findOrFail($roleId)->restore()) {
                return redirect()->route('role.index')->with('success', 'Role retrieved successfully');
            }
            return redirect()->back()->with('error', 'User can not retrieved');
        }
        abort(403, 'Unauthorized action.');
    }

    // Permanently remove the specified resource from storage.
    public function forceDelete($roleId)
    {
        // Find soft deleted role
        $role = Role::onlyTrashed()->findOrFail($roleId);
        if (auth()->user()->isAdmin()) {
            // Update users with the role to be deleted to the default role
            User::where('role_id', $role->id)->update(['role_id' => config('panel.user_role_id')]);

            // Permanently delete role
            if ($role->forceDelete()) {
                redirect()->route('role.index')->with('success', 'Role deleted successfully!');
            }
            return redirect()->route('role.index')->with('error', 'Role can not be force deleted');
        }
        abort(403, 'Unauthorized action.');
    }
}
