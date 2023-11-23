@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Roles</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Roles Data</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Roles</a>
                    </li>
                    <li class="nav-item border-none">
                        <a class="nav-link bg-light" href="{{ route('roles.create') }}"><i class="fas fa-plus"></i>Add Role</a>
                    </li>
                </ul>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Role</th>
                                <th>Permissions</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $k => $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if ($role->permissions->count() > 0)
                                    @foreach ($role->permissions as $permission)
                                    <span class="badge bg-light text-dark border-1 ">{{ $permission->name }}</span>
                                    @endforeach
                                    @else
                                    <span class="badge badge-dark">No permission</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-outline-info btn-sm" href="{{ url('admin/role/'.$role->id.'/permission') }}">Assign Permissions</a>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm text-black" onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $roles->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

