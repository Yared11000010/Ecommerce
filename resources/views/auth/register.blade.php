<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E_commerce</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backendd/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('backendd/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backendd/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
  <div class="card-header text-center">
        <a href="index2.html" class="h1"><b class=" pl-2">BYT </b><b class=" text-danger">E</b>-Commerce</a>
      </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new Users</p>

     
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group mb-3">
            <label for="name" value="{{ ('Name') }}"></label>
          <input type="text" id="name" class="form-control" name="name" :value="old('name')" required autofocus autocomplete="name"placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <label for="email" value="{{ __('Email') }}" ></label>
          <input type="email" class="form-control" id="email" type="email" name="email" :value="old('email')" required placeholder="Email" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <label for="password" value="{{ __('Password') }}" ></label>
          <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" placeholder="New Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <label for="password_confirmation" value="{{ __('Confirm Password') }}" ></label>
          <input type="password" class="form-control" id="password_confirmation" class="block mt-1 w-full" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" style="width: 20px;  height:20px" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif
            <button style="width: 100px;" type="submit" class="btn btn-primary btn-block">  {{ __('Register') }}</button>
      </form>

      
      <a href="{{ route('login') }}" class="text-center underline ">  {{ __('Already registered?') }}</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<!-- jQuery -->
<script src="{{asset('backendd/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('backendd/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('backendd/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
