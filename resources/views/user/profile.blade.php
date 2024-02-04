@extends('layouts.app')
@section('content')
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