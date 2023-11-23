@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Edit Banner</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-6" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Edit Banner</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Edit Banner</a>
                         </li>
                         @if ($user && $user->hasPermissionByRole('view_banners'))
                         <li class="nav-item">
                           <a class="nav-link " href="{{ url('admin/banners')}}"><i class="fa fa-list mr-2"></i>All Banners</a>
                         </li>
                         @endif
                       </ul>
                     <form class="row g-3" action="{{ url('admin/banner/update') }}" method="POST" enctype="multipart/form-data" >
                        @csrf

                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $banner['id'] }}">
                        <div class="col-md-6">
                            <label for="type">Banner Type</label>
                            <select class="form-control " name="type" id="type">
                               <option @if(!empty($banner['type'])&&$banner['type']=="Slider")
                                  selected="" @endif value="Slider">Slider</option>
                               <option  @if(!empty($banner['type'])&&$banner['type']=="Fix")
                               selected="" @endif  value="Fix">Fix</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label">Banner Image</label>
                             <input type="file" class="form-control" name="image">
                             @error('image')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                             <div class="pt-3">
                                <div class="row">
                                  <img src="{{ asset('/storage/banner/'.$banner['image']) }}" style="width:80px; height:40px" class=" rounded" alt="">
                                </div>
                             </div>
                         </div>

                        <div class="col-md-6">
                           <label for="link" class="form-label">Banner Link</label>
                            <input type="text" value="{{ $banner['link'] }}" class="form-control" name="link">
                            @error('link')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label">Banner Title</label>
                             <input type="text" value="{{ $banner['title'] }}" class="form-control" name="title">
                             @error('title')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-6">
                            <label for="alt" class="form-label">Banner Alternate Text</label>
                             <input type="alt" value="{{ $banner['alt'] }}" class="form-control" name="alt">
                             @error('alt')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     <div class="form-group pt-3 ">
                     <input type="submit" class=" btn btn-warning pt-2 pb-2 shadow" value="Update Banner">
                     </div>
          </form>
         </div>
        </div>
      </div>
      </div>
 </section>
@endsection
