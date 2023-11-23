@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Brand</li>
         <li class="breadcrumb-item active">All Brands</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Brands Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Brands</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_brand'))
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ route('add_brand')}}"><i class=" fas fa-plus"></i>Add Brand</a>
                </li>
                @endif
               </ul>

               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">Num</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($brands as $k => $brand)

                     <tr>
                        <td>{{ $k++ }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                           @if($brand->status==1)
                                 <a href="{{ url('admin/inactive/brands/'.$brand->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($brand->status==0)
                                 <a href="{{ url('admin/active/brands/'.$brand->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                           </td>
                        <td><img src="{{ asset('/storage/brand/'.$brand->image) }}" style="width: 50px; height:50px" alt=""></td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_brand'))
                         <a href="{{ url('admin/brands/'.$brand->id.'/edit') }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_brand'))
                         <a href="{{ url('admin/barnds/'.$brand->id.'/delete') }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this brand ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
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
