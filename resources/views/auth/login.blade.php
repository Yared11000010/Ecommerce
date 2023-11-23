<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backendd/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('backendd//plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backendd/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backendd/css/') }}">
  </head>
  <style>
 
  </style>
<body class="login-page" style="min-height: 466px;">
  <div class="login-box ">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b class=" pl-2">BYT </b><b class=" text-danger">E</b>-Commerce</a>
      </div>
      
      <div class="card-body shadow-sm">
        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
                  <!-- Email input -->
                  <div class="input-group mb-3">
                    <label for="email" value="{{ __('Email') }}" ></label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autofocus >
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                 
                  </div>
  
                  <!-- Password input -->
                  <div class="input-group mb-3">
                    <label for="password" value="{{ __('Password') }}"></label>
                    <input id="password"  class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                
                  </div>
  
                  <!-- Checkbox -->
                  <div class="row">
                    <div class="col-8">
                      <div class="icheck-primary">
                    <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>                    
                    <label for="remember">
                        {{ __('Remember me') }}
                    </label>
                  </div>
                 </div>
  
                  <!-- Submit button -->
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">
                      {{ __('Log in') }}
                    </button>
                  </div>
                </div>
                @if (Route::has('password.request'))
                        <a class="btn btn-link"  href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                @endif
                  
                </form>
                <div class="social-auth-links text-center mt-2 mb-3">
                  <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                  </a>
                  <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                  </a>
                  <p class="mb-0 text-left bg-light p-2">
                    <a class="nav-link" href="{{ route('register') }}">you don't have account ?<ins class=" text-primary ">{{ __('Sign Up') }}</ins></a>
                  </p>
                </div>
            <!-- /.social-auth-links -->
    </div>
    
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

  <!-- jQuery -->
<script src="{{ asset('backendd/plugins/jquery/jquery.min.js') }}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backendd/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backendd/dist/js/adminlte.min.js') }}"></script>
</body>
</html>