<html lang="en"><head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Forget Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="icon" type="image/x-icon" href="{{ asset('fontend/image/dist/img/1625645518.7267.png') }}" />
    <link href="{{asset('backend/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
      <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/bootstrap-icons.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/boxicons.min.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/quill.snow.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/quill.bubble.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/remixicon.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/simple-datatables.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
      @notifyCss
 </head>
 <body>
    <main>
       <div class="container">
          <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
             <div class="container">
                <div class="row justify-content-center">
                   <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                      <div class="d-flex justify-content-center py-4"> <img src="{{ asset('backend/img/bytlog.png') }}" style="height:100px; width:150px; border-radius:1rem;  box-shadow:1px 1px 11px 1px rgb(169, 229, 253);"></div>
                      <div class="card mb-3" style="border-radius:1rem; box-shadow:1px 1px 11px 1px rgb(169, 229, 253);">
                         <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">FORGET YOUR PASSWORD</h5>
                            </div>
                                <form id="loginForm" action="{{ route('ResetPasswordPost') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group row">
                                        <label for="email_address" class="col-md-4 col-form-label ">E-Mail Address</label>
                                        <div class="col-12">
                                            <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label ">Password</label>
                                        <div class="col-12">
                                            <input type="password" id="password" class="form-control" name="password" id="new_password" required autofocus>
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label">Confirm Password</label>
                                        <div class="col-12">
                                            <input type="password" id="password-confirm" class="form-control" id="confirm_password" name="password_confirmation" required autofocus>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
               <x:notify-messages />
            </section>
         </div>
      </main>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <script>
        // Form validation function
        function validateForm() {
            const newpassword = document.getElementById("new_password");
            const confirmpassword=document.getElementById("confirm_password");

            const validatenew=newpassword.value;
            const validateconfirm=confirmpassword.value;

            if(validatenew.length<8){
                alert("The new password input must be greater than 8");
                newpassword.focus();
                event.preventDefault();
                return false;
            }
            if(validateconfirm.length<8){
                alert("The confirmation password input must be greater than 8");
                confirmpassword.focus();
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
      <script src="{{asset('backend/js/apexcharts.min.js')}}"></script>
      <script src="{{asset('backend/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('backend/js/chart.min.js')}}"></script>
      <script src="{{asset('backend/js/echarts.min.js')}}"></script>
      <script src="{{asset('backend/js/quill.min.js')}}"></script>
      <script src="{{asset('backend/js/simple-datatables.js')}}"></script>
      <script src="{{asset('backend/js/tinymce.min.js')}}"></script>
      <script src="{{asset('backend/js/validate.js')}}"></script>
      @notifyJs
      <script src="{{asset('backend/js/main.js')}}"></script>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;"><defs id="SvgjsDefs1002"></defs><polyline id="SvgjsPolyline1003" points="0,0"></polyline><path id="SvgjsPath1004" d="M0 0 "></path></svg></body></html>
