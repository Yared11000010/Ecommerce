@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('Delivery Boy/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Delivery Boy</li>
            <li class="breadcrumb-item active">All Delivery Boys</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Delivery Boys Data</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Delivery Boys</a>
                    </li>

                </ul>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->roles->count() > 0)
                                        @foreach ($user->roles as $role)
                                            <span class="btn btn-sm btn-outline-success">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-dark">No Role</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('delivery_boy.assign_role', $user->id) }}" class="btn btn-outline-primary btn-sm">Assign Role</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-sm">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

