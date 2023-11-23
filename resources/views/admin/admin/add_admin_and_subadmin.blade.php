@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Admins</a></li>
            <li class="breadcrumb-item">Add Admins_and_Subadmins</li>
        </ol>
    </nav>
</div>
<section class="section col-md-6">
    <div class="card">

        <div class="card-body pt-3">

            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link bg-light disabled" href="javascript:void();"><i class=" fas fa-plus"></i>Add Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('admin/displayall') }}"><i class="fa fa-list mr-2"></i>Lists of admins</a>
                </li>
            </ul>
            <form id="loginForm" action="{{ route('store_admin_or_subadmin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-8 pt-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-8 pt-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" required name="email">
                    @error('email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-8 pt-3">
                    <label for="type" class="form-label">Admin Type</label>
                    <select class="form-select" required name="type">
                        <option value="">Select Admin Type</option>
                        @foreach ($role as $role)
                        <option value="{{$role->name}}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8 pt-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" class="form-control" id="mobile" name="mobile">
                    @error('mobile')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-8 pt-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image">
                    @error('image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-8 pt-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3">
                    <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Submit">
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
        const mobileInput = document.getElementById("mobile");
        const nameInput = document.getElementById("name");
        const password = document.getElementById("password");
        const validpassword = password.value;

        if (validpassword < 8) {
            alert("Password length must be 8 digit");
            password.focus();
            event.preventDefault();
            return false;
        }

        if (!/^[A-Za-z\s]+$/.test(nameInput.value)) {
            alert("Invalid name! Only characters are allowed.");
            nameInput.focus();
            event.preventDefault();
            return false;
        }
        // Validation for mobile (accept only 10 digits)
        if (!/^[0-9]{10}$/.test(mobileInput.value)) {
            alert("Invalid mobile number! Please enter a 10-digit mobile number.");
            mobileInput.focus();
            event.preventDefault();
            return false;
        }

        return true; // Form will be submitted if everything is valid
    }

    // Event listener for form submission
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

</script>
@endsection

