@extends('layouts.app')
<!-- Extends the layout from 'layouts.app' -->

@section('content')
    <div class="mb-2">
        <!-- Button to go back to the previous page -->
        <a href="{{ route('category.create') }}" class="btn btn-primary">
            <span class="bi bi-folder-plus"></span>
            Add new Category
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Left side of the card header -->
            <div>
                <h5 class="card-title mb-0">Permissions</h5>
            </div>

            <!-- Right side of the card header Search form -->
            <form action="{{ route('category.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $searchQuery ?? '' }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <!-- Table to display permissions -->
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <!-- Column headers -->
                    <th scope="col">Category name</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
{{--                {{ dd($categories) }}--}}
                <!-- Loop through permissions and display each permission -->
                @foreach($categories as $value)
                    <tr>
                        <!-- Output the row number -->
                        <th scope="row">{{ $loop->iteration }}</th>
                        <!-- Display permission name and description -->
                        <td>{{ $value->name }}</td>
                        <!-- Include action buttons for the permission -->
                        <td>
                            @include('category.action')
                        </td>
                    </tr>
                @endforeach
                </tbody>

                <!-- Pagination links -->
                <tfoot>
                <tr>
                    <td colspan="3" class="text-center">{{ $categories->appends(['search' => $searchQuery])->onEachSide(5)->links() }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
