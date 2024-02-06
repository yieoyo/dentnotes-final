@extends('layouts.app')
@section('content')
    <div class="mb-2">
        <button onclick="window.history.back();" class="btn btn-warning">Go Back</button>
    </div>
    <div class="row">
        <!-- Column 1 -->
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset($user->avatar) }}" class="img-fluid mb-3" alt="User Image">
                </div>
            </div>
        </div>
        <!-- Column 2 -->
        <div class="col-md-9">
            <div class="row mt-5">
                <div class="col-md-6">
                    <h3>{{ $user->name }}</h3>
                    <p>Email: {{ $user->email }}</p>
                    <p>User Role: {{ $user->role->name }}</p>
                </div>
                <div class="col-md-6">
                    @include('user.action')
                </div>
            </div>
        </div>
    </div>
@endsection
