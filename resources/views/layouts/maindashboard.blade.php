@extends('admindashboard.maindashboard')

@section('dashboard')

   <div class="pagetitle">
      <h1 style="text-align: right;">Your Report or Data</h1>
      <nav>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
         </ol>
      </nav>
   </div>
   <section class="section dashboard">
      <div class="row">
         <div class="col-lg-12">
            <div class="row">

                @if(Auth::guard('admin')->user()->vendor_id==0)
               <div class="col-xxl-3 col-md-6">
                  <div class="card info-card border-0 sales-card">
                     <div class="card-body">
                        <h5 class="card-title">Products <span>| all</span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                           <div class="ps-3">
                              <h6>{{ $allproducts }}</h6>
                              <span class="text-success small pt-1 fw-bold">All products in stock</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-3 col-md-6">
                  <div class="card info-card border-0 revenue-card">
                     <div class="card-body">
                        <h5 class="card-title">Customers <span>| All Year</span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-currency-dollar"></i></div>
                           <div class="ps-3">
                              <h6>{{ $allusers }}</h6>
                              <span class="text-success small pt-1 fw-bold">All Active Users </span> <span class="text-muted small pt-2 ps-1"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-3 col-xl-12">
                  <div class="card info-card border-0 customers-card">

                     <div class="card-body">
                        <h5 class="card-title">Vendor <span>| All Year</span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                           <div class="ps-3">
                              <h6>{{ $allvendors }}</h6>
                              <span class="text-success small pt-1 fw-bold">All Active Vendors</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-3 col-xl-12">
                  <div class="card info-card border-0 customers-card">

                     <div class="card-body">
                        <h5 class="card-title">Orders <span>| All Year </span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                           <div class="ps-3">
                              <h6>11</h6>
                              <span class="text-success small pt-1 fw-bold">All Orders</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               {{-- @if(Auth::guard('admin')->user()->type!="vendor") --}}

            @endif

            {{-- @endif --}}
                </div>
         </div>
      </div>

    </div>
   </section>
@endsection
