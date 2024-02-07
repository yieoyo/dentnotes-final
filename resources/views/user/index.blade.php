@extends('layouts.app')
@section('content')
    @can('admin')
        <!-- User DataTable -->
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
