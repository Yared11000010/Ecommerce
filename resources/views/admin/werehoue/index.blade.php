@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Warehouse</li>
         <li class="breadcrumb-item active">All Warehouses</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Warehouses Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Warehouses</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_warehouse'))
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ route('warehouses.create') }}"><i class=" fas fa-plus"></i>Add Warehouse</a>
                </li>
                @endif
               </ul>

               <table class="table datatable">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Address</th>
                        <td class="col">Capacity</td>
                        <th>phone</th>
                        <th>Email</th>
                        <td>Country</td>
                        <td>State</td>
                        <td>Status</td>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($allwerehouses as $k => $houses)

                     <tr>
                        <td>{{ $houses->id }}</td>
                        <td>{{ $houses->name }}</td>
                        <td>{{ $houses->code }}</td>
                        <td>{{ $houses->address }}</td>
                        <td>{{ $houses->capacity }}</td>
                        <td>{{ $houses->phone }}</td>
                        <td>{{ $houses->email }}</td>
                        <td>{{ $houses->country }}</td>
                        <td>{{ $houses->state }}</td>
                        <td>
                           @if($houses->status==1)
                                 <a href="{{ url('admin/warehouses/inactive/'.$houses->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($houses->status==0)
                                 <a href="{{ url('admin/warehouses/active'.$houses->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                        <td>

                        @if ($user && $user->hasPermissionByRole('edit_warehouse'))
                         <a href="{{ url('admin/warehouses/'.$houses->id.'/edit') }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_warehouse'))
                         <a href="{{ url('admin/warehouses/'.$houses->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this houses ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
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
