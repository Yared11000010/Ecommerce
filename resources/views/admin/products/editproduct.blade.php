@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Updated Product</li>
       </ol>
    </nav>
 </div>
 <section class="section " >
    <div class="col-lg-8">
        <div class="card" >
           <div class="card-body pt-1">
             <h5 class="card-title">Update Product</h5>
             <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
               <li class="nav-item border-none">
                  <a class="nav-link bg-light disabled" href=""><i class=" fas fa-plus"></i>Update Product</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view_product'))
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('products') }}"><i class="fa fa-list mr-2"></i>All Products</a>
                </li>
                @endif
              </ul>
                <form class="row g-3" action="{{ url('admin/products/update/') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="col-md-4 pt-3">
                  <label>Category:</label>
                  <select name="category" id="category" style="color:#000;" class=" d-flex form-control">
                    <option value="">-- Select Category --</option>
                          @foreach ($categories as $section)
                         <optgroup label="{{ $section['name'] }}"></optgroup>
                         @foreach ($section['categories'] as $category )
                           <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;->&nbsp;{{ $category['name'] }}</option>
                           @foreach ($category['subcategories'] as $subcategory )
                           <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;--->&nbsp;{{ $subcategory['name'] }}</option>
                         @endforeach
                         @endforeach
                          @endforeach
                </select>
                </div>
                    <div class="">
                    @include('admin.filters.category_filters')
                    </div>
                 <div class="col-md-4  pt-3">
                    <label for="brand_id" class="form-label"> Select Brand</label>
                    <select name="brand_id" class="form-select">
                       <option value="" >--Select--</option>
                       @foreach ($brands as $brand)
                       <option value="{{ $brand['id'] }}" @if (!empty($product['brand_id']==$brand['id'])) selected=""

                       @endif>{{ $brand['name'] }}</option>
                       @endforeach
                    </select>
                 </div>
                <div class="col-md-4 pt-3">
                   <label for="product_name" class="form-label">Product_name</label>
                    <input type="text" class="form-control"  value="{{ $product->product_name }}"  name="product_name">
                    @error('product_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="product_code" class="form-label">Product_code</label>
                     <input type="text" class="form-control" value="{{ $product->product_code }}"   name="product_code">
                     @error('product_code')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                    <label for="product_color" class="form-label">Product_color</label>
                     <input type="text" class="form-control" value="{{ $product->product_color}}" pattern="[A-Za-z]+" name="product_color">
                     @error('product_color')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                  <label for="product_price" class="form-label">Product_price</label>
                   <input type="number" class="form-control" value="{{ $product->product_price }}" name="product_price">
                   @error('product_price')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
                  <label for="product_selling_price" class="form-label">Product_selling_price</label>
                   <input type="number" class="form-control" value="{{ $product->product_selling_price }}" name="product_selling_price">
                   @error('product_selling_price')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>

                 <div class="col-md-4 pt-3">
                    <label for="product_discount" class="form-label">Product_Discount (%)</label>
                     <input type="number" class="form-control" value="{{ $product->product_discount }}" name="product_discount">
                     @error('product_discount')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                <div class="col-md-4 pt-3">
                    <label for="product_tax" class="form-label">Product tax</label>
                     <input type="number" class="form-control" value="{{ $product->product_tax }}" name="product_tax">
                     @error('product_tax')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                <div class="col-md-4 pt-3">
                   <label for="product_weight" class="form-label">Product_weight (mg)</label>
                    <input type="number" class="form-control" value="{{ $product->product_weight }}"  name="product_weight">
                    @error('product_weight')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                  <label for="image" class="form-label">Product Image (Recommend Size : 1000X1000)</label>
                   <input type="file" class="form-control"  name="image">
                   @error('image')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
                   <div class="pt-3">
                    <div class="row">
                      <img src="{{ asset('/storage/products/'.$product->product_image) }}" style="width:80px; margin-left:15px;  box-shadow:1px 1px 2px gray; height:50px" class=" rounded" alt="">
                    </div>
                 </div>
               </div>
               <div class="col-md-4 pt-3">
                  <label for="product_video" class="form-label">Product Video (Recommend Size : Less than 2 MB)</label>
                   <input type="file" class="form-control" accept=".mp4" name="product_video">
                   @error('product_video')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
                   <div class="pt-3">

                    <div class="row">
                      <video src="{{ asset('/storage/products/video/'.$product->product_video) }}" style="width:80px; margin-left:15px;  box-shadow:1px 1px 2px gray; height:50px" controls></video>
                    </div>
                 </div>
               </div>
               <div class="col-md-4 pt-3">
                  <label for="description">Product Description</label>
                  <textarea class="form-control"   name="description" id="description" cols="30" rows="4">
                    {{ $product->description }}
                  </textarea>
                  @error('description')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
                  <label for="meta_description">Meta Product Description</label>
                  <textarea class="form-control " name="meta_description" id="meta_description" cols="30" rows="4">
                    {{ $product->meta_description }}
                  </textarea>
                  @error('meta_description')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
                <div class="col-md-4 pt-3">
                   <label for="meta_title" class="form-label">Meta_title</label>
                    <input type="text" class="form-control " value="{{ $product->meta_title }}" name="meta_title">
                    @error('meta_title')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="meta_keywords" class="form-label">Meta_keywords</label>
                    <input type="text" class="form-control"  value="{{ $product->meta_keywords }}"   name="meta_keywords">
                    @error('meta_keywords')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                  <label for="group_code" class="form-label">Group_code</label>
                   <input type="text" class="form-control " value="{{ $product->group_code }}"  name="group_code">
                   @error("group_code")
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>

                    <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-warning  pt-2 pb-2 shadow" value="Update Product">
                    </div>
                 </form>
                </div>
            </div>
          </div>
 </section>
@endsection
@section('script')
<script>
 $(document).ready(function () {

  /*------------------------------------------
  --------------------------------------------
  Country Dropdown Change Event
  --------------------------------------------
  --------------------------------------------*/
          $('#category').on('change', function () {
              var idCountry = this.value;
              $("#sub_category").html('');
              $.ajax({
                  url: "{{url('admin/fetchsubcategory')}}",
                  type: "POST",
                  data: {
                    category_id: idCountry,
                      _token: '{{csrf_token()}}'
                  },
                  dataType: 'json',
                  success: function (result) {
                      $('#sub_category').html('<option value="">-- Select SuCategory --</option>');
                      $.each(result.states, function (key, value) {
                          $("#sub_category").append('<option  value="' + value
                              .id + '">' + value.name + '</option>');
                      });

                  }
              });
          });

        $("#category").on('change',function(){
          var category_id=$(this).val();
          // alert(category_id);
          $.ajax({

            type:'post',
            url:'<?php echo url('/admin/category-filters') ?>',
            data:{category_id:category_id ,_token: '{{csrf_token()}}'},
            success:function(resp){
              $(".displayfilters").html(resp.view);
            }
          })
        });



        });
</script>
@endsection
