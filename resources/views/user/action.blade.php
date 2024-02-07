<div class="btn-group">
    @if((Route::currentRouteName() == 'user.index' && !isset($_GET["show_deleted"])))
        <a href="{{ route('user.view', $id ?? $user->id) }}" class="btn btn-sm btn-success" title="View">
            <span class="bi bi-eye"></span> <!-- Bootstrap eye icon -->
        </a>
    @endif
    @if(isset($_GET["show_deleted"]))
        <a href="{{ route('user.retrieveDleted', $id ?? $user->id) }}" class="btn btn-sm btn-success" title="Retrieve">
            <span class="bi bi-arrow-return-left"></span> <!-- Bootstrap eye icon -->
        </a>
    @endif
    @if((Route::currentRouteName() == 'user.index' && !isset($_GET["show_deleted"])) || Route::currentRouteName() == 'user.view')
        <a href="{{ route('user.edit', $id ?? $user->id) }}" class="btn btn-sm btn-warning" title="Edit">
            <span class="bi bi-pencil"></span> <!-- Bootstrap pencil icon -->
        </a>
    @endif
    @can('admin')
        <button type="button" class="btn btn-sm btn-danger" title="Delete"
                onclick="confirmDelete( {{ $id ?? $user->id }} )">
            <span class="bi bi-trash"></span> <!-- Bootstrap trash icon -->
        </button>
    @endcan
</div>

<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form dynamically
                let form = document.createElement('form');
                @php
                    echo isset($_GET["show_deleted"]) && $_GET["show_deleted"] ? "form.action = '/users/pd/'+ userId;" : "form.action = '/users/'+ userId;";
                @endphp
                    form.method = 'POST'; // Use POST method for delete to comply with RESTful conventions
                form.innerHTML = '<input type="hidden" name="_method" value="POST">' +
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">';

                document.body.appendChild(form);

                // Submit the form
                form.submit();
            }
        });
    }
</script>
