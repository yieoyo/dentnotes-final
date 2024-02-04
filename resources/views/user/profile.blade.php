@extends('layouts.app')
@section('content')

    <!-- Breadcrumb with Edit Profile and Update Password Buttons -->
    <div class="d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>

        <div>
            <button class="btn btn-primary me-2">Edit Profile</button>
            <button class="btn btn-secondary">Update Password</button>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="card">
        <div class="card-body">
            <!-- Profile Photo -->
            <img src="your-profile-photo.jpg" class="img-fluid rounded-circle mx-auto d-block" alt="Your Profile Photo" style="max-width: 150px;">

            <!-- Full Name -->
            <h3 class="text-center mt-3">Your Full Name</h3>

            <!-- Email -->
            <p class="text-center"><strong>Email:</strong> your.email@example.com</p>

            <!-- Role Information -->
            <p class="text-center"><strong>Role:</strong> Your Role</p>
        </div>
    </div>
@endsection