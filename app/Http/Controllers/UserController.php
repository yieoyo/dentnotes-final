<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');

            // Generate a unique filename using the original file extension
            $image_name = rand() . '.' . $image->getClientOriginalExtension();

            // Store the file in the private disk with the new filename
            $imagePath = $image->storeAs('private/avatar', $image_name, 'local');
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
            'avatar' => $imagePath ?? 'private/avatar/avatar.jpg',
        ]);

        return redirect()->route('user.index');
    }

    public function show($id)
    {
        // Your code for displaying a specific resource
    }

    public function edit($id)
    {
        // Your code for displaying the edit resource form
    }

    public function update(Request $request, $id)
    {
        // Your code for updating a specific resource
    }

    public function destroy($id)
    {
        // Your code for deleting a specific resource
    }
}
