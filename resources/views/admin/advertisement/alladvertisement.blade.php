@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Advertisement</li>
         <li class="breadcrumb-item active">All Advertisement</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Advertisement Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Advertisement</a>
                </li>
                  @if ($user && $user->hasPermissionByRole('create_advertisment'))
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ url('admin/adverstisements/add') }}"><i class=" fas fa-plus"></i>Add Advertisement</a>
                  </li>
                  @endif
               </ul>

               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <td scope="col">title</td>
                        <th scope="col">Image</th>
                        <th scope="col">description</th>
                        <th scope="col">price</th>
                        <th scope="col">Link</th>
                        <th scope="col">is Approved</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($adver as $k => $ad)

                     <tr>
                        <td>{{ $ad['id'] }}</td>
                        <td>{{ $ad['title'] }}</td>
                        <td><img src="{{ asset('/storage/adver/'.$ad['image']) }}" style="width: 80px; height:40px; box-shadow:1px 1px 2px 1px gray" alt=""></td>

                        <td>{{ $ad['description'] }}</td>
                        <td>{{ $ad['price'] }}</td>
                        <td>{{ $ad['adv_links'] }}</td>
                        <td>
                           @if($ad['is_approved']==1)
                                 <a href="{{ url('admin/adverstisements/inactive/'.$ad['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif($ad['is_approved']==0)
                                 <a href="{{ url('admin/adverstisements/active/'.$ad['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                           </td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_advertisment'))
                         <a href="{{ url('admin/adverstisements/edit/'.$ad['id']) }}" style="background-color: rgb(242, 248, 248)" class=" btn btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_advertisment'))
                         <a href="{{ route('delete_adverstisements',['id'=>$ad['id']]) }}" style="background-color: rgb(204, 199, 199); border:none" data-confirm-delete="true"  class="btn btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
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

