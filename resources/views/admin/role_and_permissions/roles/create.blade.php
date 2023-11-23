@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Add Role</li>
        </ol>
    </nav>
</div>
<section class="section col-md-6">
    <div class="card">
        <div class="card-body pt-3">
            <h5 class="card-title">Add Role</h5>
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Add Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('roles.index') }}"><i class="fa fa-list mr-2"></i>All Roles</a>
                </li>
            </ul>
            <form class=" g-3" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="SAVE">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

