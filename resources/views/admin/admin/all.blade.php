@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">All Admin</li>
         <li class="breadcrumb-item active">All Admins</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Lists of admins</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Admins</a>
                </li>

               </ul>

               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">Admin ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Email</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($all as $k => $all)

                     <tr>
                        <td>{{ $all['id'] }}</td>
                        <td>{{ $all['name']}}</td>
                        <td>
                            @if($all['type'])
                            <span style="border-radius: 0.2rem; padding-left:4px; padding-top:4px; padding-bottom:4px; padding-right:4px; background-color: rgb(56, 119, 119); color:black"  class="  text-white active-btn">{{ $all['type'] }}</span></a>
                            @endif
                        </td>
                        <td>{{ $all['mobile']}}</td>
                        <td>{{ $all['email']}}</td>
                        <td>
                           @if(!empty($all['image']))
                           <img src="{{ asset('storage/admin/image/'.$all['image']) }}" style=" box-shadow:1px 1px 3px gray; border-radius:2rem;width: 40px; height:40px;" class="" alt="">
                           @else
                           <img  src="{{ asset('/storage/products/noimagefile.png') }}" style="box-shadow:1px 1px 3px gray;  border-radius:2rem; width: 40px; height:40px;" class="" alt="">
                           @endif
                        </td>
                        <td>
                           @if($all['status']==1)
                                 <a href="{{ url('admin/inactive/'.$all['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($all['status']==0)
                                 <a href="{{ url('admin/active/'.$all['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                        </td>

                        <td>
                            @if ($user && $user->hasPermissionByRole('view_admin'))
                            <a href="{{ url('admin/edit_admin/'.$all['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                            @endif
                            @if ($user && $user->hasPermissionByRole('delete_admin'))
                            <a href="{{ url('admin/admin-subadmin/'.$all['id']) }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Admin or SubAdmin ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
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
