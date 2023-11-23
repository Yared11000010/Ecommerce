@foreach ($appsettings as $setting)

<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between"> <a href="{{ route('maindashboard') }}" class="logo d-flex align-items-center"> <img src="{{ asset('/storage/appsettings/1.png') }}" style="height:700px; width:50px; border-radius:5px; "><b>E-commerce</b> </a> <i class="bi bi-list toggle-sidebar-btn"></i></div>
  <nav class="header-nav ms-auto">
     <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none"> <a class="nav-link nav-icon search-bar-toggle " href="#"> <i class="bi bi-search"></i> </a></li>

        <li class="nav-item dropdown pe-3">
         @if(!empty(Auth::guard('admin')->user()->image))
           <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
             <img class=" rounded object-cover" src="{{ asset('/storage/admin/image/'.Auth::guard('admin')->user()->image) }}" alt=""> {{ Auth::guard('admin')->user()->name }}<span class="d-none d-md-block dropdown-toggle ps-2"></span>
            </a>
         @else
         <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img class=" rounded object-cover" src="{{ asset('/storage/products/noimagefile.png') }}" alt=""> {{ Auth::guard('admin')->user()->name }}<span class="d-none d-md-block dropdown-toggle ps-2"></span>
           </a>
         @endif
           <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                 <h6></h6>
                 <span>Settings</span>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ route('adminlogout') }}"> <i class="bi bi-person"></i> <span>Logout</span> </a></li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/update_admin_password') }}"> <i class="bi bi-gear"></i> <span>Changer Your Password</span> </a></li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/updateadmindetails') }}"> <i class="bi bi-question-circle"></i> <span>Update Your Profile</span> </a></li>
              <li>
                 <hr class="dropdown-divider">
              </li>

           </ul>
        </li>
     </ul>
     {{-- @include('sweetalert::alert') --}}

     <x:notify-messages />
  </nav>
</header>
@endforeach

