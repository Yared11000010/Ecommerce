@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">App Settings</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-8" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Update App Settings</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                     </ul>
                     <form id="loginForm" class="row g-3" action="{{ url('admin/appsettings/update') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                           <label for="title" class="form-label">Website Titile</label>
                            <input type="text" class="form-control" value="{{ $appsetting->application_title }}" name="title">
                            @error('title')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                           <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" value="{{ $appsetting->description }}" name="description">
                            @error('description')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                             <input type="text" class="form-control" value="{{ $appsetting->address }}" name="address">
                             @error('address')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                             <input type="email" class="form-control" value="{{ $appsetting->email_address }}" name="email">
                             @error('email')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone_no" class="form-label">Phone</label>
                             <input type="number" class="form-control" id="phone" value="{{ $appsetting->phone_no }}" name="phone_no">
                             @error('phone_no')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="favicon" class="form-label">Favicon</label>
                             <input type="file" class="form-control" name="favicon">
                             <div class="image">
                                <img src="{{ asset('/storage/appsettings/'.$appsetting->favicon) }}" style="width: 50px; height:50px" alt="">

                             </div>
                             @error('favicon')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="logo" class="form-label">Logo</label>
                             <input type="file" class="form-control" name="logo">
                             <div class="image">
                                <img src="{{ asset('/storage/appsettings/'.$appsetting->logo) }}" style="width: 50px; height:50px" alt="">
                             </div>
                             @error('logo')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="language" class="form-label">Language</label>
                             <input type="text" class="form-control"  id="language" value="{{ $appsetting->language }}" name="language">
                             @error('language')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="time_zone" class="form-label ">Time_zone</label>
                             <input type="text" class="form-control" disabled value="{{ $appsetting->time_zone }}"  name="time_zone">
                             @error('time_zone')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="footer_text" class="form-label"> Footer Text</label>
                            <textarea name="footer_text" id="" cols="30" ows="10" class=" form-textarea">
                                {{ $appsetting->footer_text }} r
                            </textarea>
                            @error('footer_text')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="youtube" class="form-label">Youtube link</label>
                             <input type="text" class="form-control" value="{{ $appsetting->youtube }}" name="youtube">
                             @error('youtube')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="facebook" class="form-label">facebook link</label>
                             <input type="text" class="form-control" value="{{ $appsetting->facebook }}" name="facebook">
                             @error('facebook')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="twitter" class="form-label">twitter link</label>
                             <input type="text" class="form-control" value="{{ $appsetting->twitter }}" name="twitter">
                             @error('twitter')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label">Whatsapp link</label>
                             <input type="text" class="form-control" value="{{ $appsetting->whatsapp }}" name="whatsapp">
                             @error('whatsapp')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="panel_icon" class="form-label">panel_icon</label>
                             <input type="file" class="form-control" name="panel_icon">
                             <div class="image">
                                <img src="{{ asset('/storage/appsettings/'.$appsetting->panel_icon) }}" style="width: 50px; height:50px" alt="">
                             </div>
                             @error('panel_icon')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="plane_text" class="form-label">Admin Plane text</label>
                             <input type="text" class="form-control" value="{{ $appsetting->panel_text }}" name="plane_text">
                             @error('plane_text')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="plane_footer_text" class="form-label">Admin Plane Footer text</label>
                             <input type="text" class="form-control" value="{{ $appsetting->panel_footer_text }}" name="plane_footer_text">
                             @error('plane_footer_text')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                     <div class="form-group pt-3 ">
                     <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update Website Settings">
                     </div>
          </form>
         </div>
        </div>
      </div>
      </div>
 </section>
 <script>
    // Form validation function
    function validateForm() {
        const language = document.getElementById("language");
        const phone = document.getElementById("phone");

            if (!/^[A-Za-z\s]+$/.test(language.value)) {
                alert("Invalid Language Name! Only characters are allowed.");
                language.focus();
                event.preventDefault();
                return false;
            }
                  // Validation for mobile (accept only 10 digits)
           if (!/^[0-9]{10}$/.test(phone.value)) {
                alert("Invalid mobile number! Please enter a 10-digit mobile number.");
                phone.focus();
                event.preventDefault();
                return false;
            }

        return true; // Form will be submitted if everything is valid
    }

    // Event listener for form submission
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
@endsection
