@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Add Product</li>
       </ol>
    </nav>
 </div>
 <section class="section " >
    <div class="col-lg-8">
        <div class="card" >
           <div class="card-body pt-1">
             <h5 class="card-title">Add Product</h5>
             <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
               <li class="nav-item border-none">
                  <a class="nav-link bg-light disabled" href=""><i class=" fas fa-plus"></i>Add Product</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view_product'))
               <li class="nav-item">
                 <a class="nav-link active" href="{{ route('products') }}"><i class="fa fa-list mr-2"></i>All Products</a>
               </li>
               @endif

              </ul>
                <form class="row g-3" action="{{ url('admin/store_product') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('POST')
                <div class="col-md-4  pt-3">
                  <label>Category:</label>
                  <select name="category" id="category" style="color:#000;" class="form-control">
                      <option value="">-- Select Category --</option>
                            @foreach ($categories as $section)
                           <optgroup label="{{ $section['name'] }}"></optgroup>
                           @foreach ($section['categories'] as $category )
                             <option value="{{ $category['id'] }}">&nbsp;&nbsp;->&nbsp;{{ $category['name'] }}</option>
                             @foreach ($category['subcategories'] as $subcategory )
                             <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;--->&nbsp;{{ $subcategory['name'] }}</option>
                           @endforeach
                           @endforeach
                            @endforeach
                  </select>
                 </div>
                 <div class="displayfilters">
                 @include('admin.filters.category_filters')
                </div>
                 <div class="col-md-4  pt-3">
                    <label for="brand_id" class="form-label"> Select Brand</label>
                    <select name="brand_id" class="form-select">
                       <option value="" >--Select--</option>
                       @foreach ($brands as $brand)
                       <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                       @endforeach
                    </select>
                 </div>
                <div class="col-md-4 pt-3">
                   <label for="product_name" class="form-label">Product_name</label>
                    <input type="text" class="form-control"    name="product_name">
                    @error('product_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 pt-3">
                    <label for="product_code" class="form-label">Product_code</label>
                     <input type="text" class="form-control"  name="product_code">
                     @error('product_code')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                    <label for="product_color" class="form-label">Product_color</label>
                     <input type="text" class="form-control" pattern="[A-Za-z]+"  name="product_color">
                     @error('product_color')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                  <label for="product_price" class="form-label">Product_price</label>
                   <input type="number" class="form-control"  name="product_price">
                   @error('product_price')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
                  <label for="product_selling_price" class="form-label">Product_selling_price</label>
                   <input type="number" class="form-control"  name="product_selling_price">
                   @error('product_selling_price')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
                <div class="col-md-4 pt-3">
                <label for="product_discount" class="form-label">Product_Discount (%)</label>
                    <input type="number" class="form-control"  name="product_discount">
                    @error('product_discount')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                <label for="product_tax" class="form-label">Product tax</label>
                    <input type="number" class="form-control"  name="product_tax">
                    @error('product_tax')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="product_weight" class="form-label">Product_weight (mg)</label>
                    <input type="number" class="form-control"  name="product_weight">
                    @error('product_weight')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                  <label for="image" class="form-label">Product Image (Recommend Size : 1000X1000)</label>
                   <input type="file" class="form-control" name="image">
                   @error('image')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
                  <label for="product_video" class="form-label">Product Video (Recommend Size : Less than 2 MB)</label>
                   <input type="file" class="form-control" accept=".mp4" name="product_video">
                   @error('product_video')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
                  <label for="description">Product Description</label>
                  <textarea class="form-control" name="description" id="description" cols="30" rows="4">
                  </textarea>
                  @error('description')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
                  <label for="meta_description">Meta Product Description</label>
                  <textarea class="form-control " name="meta_description" id="meta_description" cols="30" rows="4">
                  </textarea>
                  @error('meta_description')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
                <div class="col-md-4 pt-3">
                   <label for="meta_title" class="form-label">Meta_title</label>
                    <input type="text" class="form-control "  name="meta_title">
                    @error('meta_title')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="meta_keywords" class="form-label">Meta_keywords</label>
                    <input type="text" class="form-control"    name="meta_keywords">
                    @error('meta_keywords')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="group_code" class="form-label">Group_code</label>
                    <input type="text" class="form-control "  name="group_code">
                    @error("group_code")
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="col-md-4 pt-3  custom-control custom-checkbox pt-2">
                  <label class="custom-control-label" for="is_featured">Is Featured</label><br>
                  <input type="checkbox" class="custom-control-input form-control" id="is_featured"  style="width:25px; height:25px" name="is_featured">
                </div> --}}

                 <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Save Product">
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
                          $("#sub_category").append('<option value="' + value
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
