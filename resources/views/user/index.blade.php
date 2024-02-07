@extends('layouts.app')
@section('content')
    @can('admin')
        <!-- User DataTable -->
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Manage Users</span>
                @if(request()->has('show_deleted'))

                    <a class="btn btn-sm btn-warning" href="{{ route('user.index') }}">Go Back</a>
                @else

                    <a class="btn btn-sm btn-warning" href="{{ route('user.index') }}?show_deleted=true">Show Deleted</a>
                @endif

            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
