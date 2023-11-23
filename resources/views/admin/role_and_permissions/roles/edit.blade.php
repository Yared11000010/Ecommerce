@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Edit Role</li>
        </ol>
    </nav>
</div>
<section class="section col-md-8">
    <div class="card">
        <div class="card-body pt-3">
            <h5 class="card-title">Edit Role</h5>
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Edit Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('roles.index') }}"><i class="fa fa-list mr-2"></i>All Roles</a>
                </li>
            </ul>
            <form class="row g-3" action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" value="{{ $role->name }}" class="form-control" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

