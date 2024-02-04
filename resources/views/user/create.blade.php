@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Basic Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="roleSelect" class="form-label">Role:</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="roleSelect" name="role">
                        <option value="2">User</option>
                        <option value="1">Admin</option>
                    </select>
                    @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="statusSelect" class="form-label">Status:</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="statusSelect" name="status">
                        <option value="1">Pending</option>
                        <option value="2">Active</option>
                        <option value="3">Inactive</option>
                        <option value="4">Banned</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-5">Create user</button>
        </form>
    </div>
</div>

@endsection