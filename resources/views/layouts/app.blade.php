<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/icono.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/icono.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page }} - {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <script src="https://kit.fontawesome.com/d15de51c80.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link href="{{ asset('assetsmenu/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/complete.css') }}" rel="stylesheet" />
    <link href="{{ asset('assetsmenu/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <!--alertifyjs
    ================================================== -->
    <!-- CSS -->
    <script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  

</head>

<body class="white-content {{ $class ?? '' }}">
    @auth()
        <div class="wrapper">
            @include('layouts.navbars.sidebar')
            <div class="main-panel">
                @include('layouts.navbars.navbar')

                <div class="content">
                    @yield('content')
                </div>
                @include('layouts.navbars.footer')

            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        @include('layouts.navbars.navbar')
        <div class="wrapper wrapper-full-page">
            <div class="full-page {{ $contentClass ?? '' }}">
                <div class="content">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <script src="{{ asset('assetsmenu/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assetsmenu/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assetsmenu/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assetsmenu/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--  Google Maps Plugin    
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assetsmenu/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assetsmenu/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! 
    <script src="{{ asset('assetsmenu/demo/demo.js') }}"></script>-->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!--LIBRERIAS VIEJAS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.0/slimselect.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    @stack('js')
    <script>
        $(document).ready(function() {
        });
    </script>
</body>

</html>
