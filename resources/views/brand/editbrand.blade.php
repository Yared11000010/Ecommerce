@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Edit Brand</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-8" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Edit Brand</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Edit Brand</a>
                         </li>
                         @if ($user && $user->hasPermissionByRole('view_brand'))
                         <li class="nav-item">
                           <a class="nav-link " href="{{ route('brands') }}"><i class="fa fa-list mr-2"></i>All Brand</a>
                         </li>
                         @endif
                       </ul>
                     <form class="row g-3" action="{{ url('admin/brands/update') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $brand->id }}">
                        <div class="col-md-6">
                           <label for="name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" value="{{ $brand->name }}" name="name">
                            @error('name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                           <label for="image" class="form-label">Brand Image</label>
                            <input type="file" class="form-control" value="{{ $brand->image }}" name="image">
                            @error('image')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                            <div class="pt-3">
                              <div class="row">
                                <img src="{{ asset('/storage/brand/'.$brand->image) }}" style="width:80px; margin-left:15px;  border:1px solid black; height:50px" class=" rounded" alt="">
                              </div>
                           </div>
                        </div>

                         <div class="col-md-6  custom-control custom-checkbox pt-2">
                           <label class="custom-control-label" for="status">Status</label><br>
                           <input type="checkbox" class="custom-control-input form-control" id="status" style="width:25px; height:25px"  {{ $brand->status=='1'?'checked':'' }} name="status">
                         </div>

                     <div class="form-group pt-3 ">
                     <input type="submit" class=" btn btn-warning pt-2 pb-2 shadow" value="UPDATE">
                     </div>
          </form>
         </div>
        </div>

 </section>
@endsection
