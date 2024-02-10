@extends('layouts.app')
@section('content')
    <div class="mb-2">
        <!-- Button to go back to the previous page -->
        <a href="{{ route('category.index') }}" class="btn btn-warning"><span class="bi bi-arrow-return-left"></span>
            Go Back
        </a>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Fill Information</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('category.update', $category->uuid) }}">
                @csrf

                <div class="row">
                    <div class="col-6">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name" value="{{ $category->name }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-5"><span class="bi bi-cloud-arrow-up"></span> Update Category</button>
                <button onclick="window.history.back();" class="btn btn-danger mt-5"><span class="bi bi-x-octagon"></span>
                    Cancel
                </button>
            </form>
        </div>
    </div>

@endsection
