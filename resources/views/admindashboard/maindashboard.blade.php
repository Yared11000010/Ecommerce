<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <link rel="icon" type="image/x-icon" href="{{ asset('fontend/image/dist/img/1625645518.7267.png') }}" />
      <title>
          BYT✌️ Multivendor Ecommerce
      </title>
      <meta name="robots" content="noindex, nofollow">
      <meta content="" name="description">
      <meta content="" name="keywords">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

      <link href="{{asset('backend/img/favicon.png')}}" rel="icon">
      <link href="{{asset('backend/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
      <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/bootstrap-icons.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/boxicons.min.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/quill.snow.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/quill.bubble.css')}}" rel="stylesheet">
      <link href="{{asset('backend/css/remixicon.css')}}" rel="stylesheet">
      {{-- <link href="{{asset('backend/css/simple-datatables.css')}}" rel="stylesheet"> --}}
      <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
      <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
       <link rel="stylesheet" href="{{ asset('backend/js/aiz-core.js') }}">
      {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      @notifyCss

   </head>
   <body>

    @include('admindashboard.header')
    @include('admindashboard.leftsidebar')
    <main id="main" class="main" style="background-color:rgb(242, 244, 245)">
    @yield('dashboard')
    </main>
    @include('admindashboard.footer')
         <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
            <script src="{{asset('backend/js/apexcharts.min.js')}}"></script>
            <script src="{{asset('backend/js/bootstrap.bundle.min.js')}}"></script>
            <script src="{{asset('backend/js/chart.min.js')}}"></script>
            <script src="{{asset('backend/js/echarts.min.js')}}"></script>
            <script src="{{asset('backend/js/quill.min.js')}}"></script>
            {{-- <script src="{{asset('backend/js/simple-datatables.js')}}"></script> --}}
            <script src="{{asset('backend/js/tinymce.min.js')}}"></script>
            <script src="{{asset('backend/js/validate.js')}}"></script>
            <script src="{{asset('backend/js/main.js')}}"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
            <script src="//code.jquery.com/jquery-3.5.1.js"></script>
            <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            <script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
          <script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
          <script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
            <script>
                $(document).ready(function() {
                $('#example').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],

                } );
            } );

        </script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
         <script type="text/javascript">

            $('.confirm-button').click(function(event) {
                var form =  $(this).closest("form");
                  var name = $(this).data("name");
                  event.preventDefault();
                  swal({
                      title: `Are you sure you want to delete this record?`,
                      text: "If you delete this, it will be gone forever.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      form.submit();
                    }
                  });
            });
        </script>
            @yield('jquery')
            @notifyJs
            //add this into main layouts
           @yield('script')

   </body>
</html>
