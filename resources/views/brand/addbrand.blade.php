@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Add Brand</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-8" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Add Brand</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Add Brand</a>
                         </li>
                        @if ($user && $user->hasPermissionByRole('view_brand'))
                        <li class="nav-item">
                          <a class="nav-link " href="{{ route('brands') }}"><i class="fa fa-list mr-2"></i>All Brand</a>
                        </li>
                        @endif
                       </ul>
                     <form class="row g-3" action="{{ url('admin/brands/store') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="col-md-6">
                           <label for="name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" name="name">
                            @error('name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                           <label for="image" class="form-label">Brand Image</label>
                            <input type="file" class="form-control" name="image">
                            @error('image')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                         <div class="col-md-6  custom-control custom-checkbox pt-2">
                           <label class="custom-control-label" for="status">Status</label><br>
                           <input type="checkbox" class="custom-control-input form-control" id="status" style="width:25px; height:25px" name="status">
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
