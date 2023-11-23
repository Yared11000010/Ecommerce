@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">All Products</li>
         <li class="breadcrumb-item active">All Products</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Product Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active disabled" href=""><i class="fa fa-list mr-2"></i>All Products</a>
                </li>
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ route('addproduct')}}"><i class=" fas fa-plus"></i>Add Product</a>
                </li>
               </ul>

               <table id="example" class="table datatable ml-4 mr-4">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col" style="width: 10px">Name</th>
                        <th scope="col">Product Code</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Category</th>
                        {{-- <th scope="col">SubCategory</th> --}}
                        <th scope="col">Group</th>
                        <th scope="col" style="width: 10px">Is Featured</th>
                        <th scope="col">Added by</th>

                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $k => $product)

                     <tr>
                        <td>{{ $product['id'] }}</td>
                        <td>{{ $product['product_name']}}</td>
                        <td>{{ $product['product_code']}}</td>
                        <td>
                           @if(!empty($product['product_image']))
                           <img src="{{ asset('/storage/products/'.$product['product_image']) }}" style="width: 50px; box-shadow:1px 1px 2px 2px rgb(90, 89, 89); border-radius:0.05rem; height:50px" alt="">
                           @else
                           <img src="{{ asset('/storage/products/noimagefile.png') }}" style="width: 50px; box-shadow:1px 1px 2px 2px rgb(90, 89, 89); border-radius:0.05rem; height:50px" alt="">
                           @endif
                        </td>
                        <td>{{ $product['category']['name']}}</td>
                        {{-- <td>{{ $product['subcategory']['name']}}</td> --}}
                        <td>{{ $product['group']['name']}}</td>
                        <td>
                        @if($product['is_featured']=='Yes')
                        <a href="{{ url('admin/notfeatured/product/'.$product['id']) }}"><span style="border-radius: 0.2rem;padding-left:6px;padding-right:6px; background-color:rgb(141, 220, 234); color:green">Yes</span></a>
                        @elseif ($product['is_featured']=='No')
                        <a href="{{ url('admin/featured/product/'.$product['id']) }}"><span style="border-radius: 0.2rem;padding-left:6px;padding-right:6px;background-color:rgb(245, 156, 116); color:rgb(59, 9, 9)">No</span></a>
                        @endif
                        </td>

                        <td>
                            @if($product['admin_type']=='vendor')
                            <a href="{{ url('admin/view_vendor_details/'.$product['admin_id']) }}" class=" underline">{{ ucfirst($product['admin_type']) }}</a>
                            @else
                            {{ ucfirst($product['admin_type']) }}
                            @endif
                        </td>

                        <td>
                            @if($product['status']==1)
                                 <a href="{{ url('admin/inactive/product/'.$product['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($product['status']==0)
                                 <a href="{{ url('admin/active/product/'.$product['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                        </td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_product'))
                         <a href="{{ url('admin/edit/product/'.$product['id']) }}"  style="background-color:rgb(239, 239, 239) " class=" btn btn-sm"> <i class="ri-ball-pen-fill"></i></a>
                        @endif

                        @if ($user && $user->hasPermissionByRole('add_attribute'))
                         <a href="{{ url('admin/products/add_attribute/'.$product['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm"> <i class="bx bx-add-to-queue"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('add_image_to_product'))
                         <a href="{{ url('admin/products/images/'.$product['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm"> <i class="ri-camera-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_product'))
                         <a href="{{ url('admin/product/delete/'.$product['id'])  }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Product ? ') "  class=" btn-sm"><i class=" ri-delete-bin-6-fill"></i></a>
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

