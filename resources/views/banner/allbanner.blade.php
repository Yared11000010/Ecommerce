@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Banner</li>
         <li class="breadcrumb-item active">All Banners</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Banners Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Banners</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_banners'))
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ url('admin/banners/create') }}"><i class=" fas fa-plus"></i>Add Banner</a>
                </li>
                @endif
               </ul>
               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <td scope="col">Type</td>
                        <th scope="col">Image</th>
                        <th scope="col">Link</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $k => $banner)

                     <tr>
                        <td>{{ $banner['id'] }}</td>
                        <td>{{ $banner['type'] }}</td>
                        <td><img src="{{ asset('/storage/banner/'.$banner['image']) }}" style="width: 80px; height:40px; box-shadow:1px 1px 2px 1px gray" alt=""></td>

                        <td>{{ $banner['link'] }}</td>
                        <td>{{ $banner['title'] }}</td>
                        <td>
                           @if($banner['status']==1)
                                 <a href="{{ url('admin/banners/inactive/'.$banner['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class=" bg-success text-white    active-btn">Active</span></a>
                           @elseif($banner['status']==0)
                                 <a href="{{ url('admin/banners/active/'.$banner['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class=" bg-danger  text-white    active-btn">Inactive</span></a>
                            @endif
                           </td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_banners'))
                         <a href="{{ url('admin/banners/edit/'.$banner['id']) }}" style="background-color: rgb(178, 201, 201)" class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_banners'))
                         <a href="{{ url('admin/banners/delete/'.$banner['id']) }}" style="background-color: rgb(90, 56, 56); border:none" onclick="return confirm('Are you sure,you want to delete this Banner ?? ') " class="btn btn-danger btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
                        @endif
                        </td>
                     </tr>
                     @endforeach

                  </tbody>
               </table>
               <div class=" pagination-sm">
                  {{-- {{ $categories->links() }} --}}
               </div>

            </div>
         </div>
      </div>
   </div>
 </section>

@endsection
