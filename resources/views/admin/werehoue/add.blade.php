@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Create Warehouse</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-8" >
    <div class="card border-0 shadow-sm">
       <div class="card-body pt-3">
                      <h5 class="card-title">Create Warehouse</h5>
                      <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                         <li class="nav-item border-none">
                            <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Create Warehouse</a>
                          </li>
                          {{-- @if ($user && $user->hasPermissionByRole('view_brand')) --}}
                          <li class="nav-item">
                            <a class="nav-link " href="{{ route('warehouses.index') }}"><i class="fa fa-list mr-2"></i>All Warehouses</a>
                          </li>
                          {{-- @endif --}}
                        </ul>
                        <form method="POST" action="{{ route('warehouses.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">Code:</label>
                                <input type="text" id="code" name="code" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">State:</label>
                                <select id="city" name="state" class="form-select" required>
                                    <option value="oromia" >Oromia</option>
                                    <option value="amahra" >Amahra</option>
                                    <option value="debub" >Debub</option>
                                    <!-- Add more cities as needed -->
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Country:</label>
                                <select id="country" name="country" class="form-select" required>
                                    @foreach ($allcountires as $country)
                                    <option value="{{ $country->country_name}}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
          </div>
         </div>

  </section>

@endsection
