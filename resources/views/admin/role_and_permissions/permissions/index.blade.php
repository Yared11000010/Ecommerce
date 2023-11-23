@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Permissions</li>
         <li class="breadcrumb-item active">All Permissionss</li>
      </ol>
   </nav>
 </div>
 <section class="section">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Permissions Data</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="fa fa-list mr-2"></i>All Permissions</a>
                    </li>
                    <li class="nav-item border-none">
                        <a class="nav-link bg-light" href="{{ route('permissions.create') }}"><i class="fas fa-plus"></i>Add Permissions</a>
                    </li>
                </ul>

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this permission?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {!! $permissions->links() !!}
                </div>
            </div>
        </div>
    </div>

 </section>

@endsection
