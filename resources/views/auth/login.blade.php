<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name') }}</title> 
    <meta name="description" content="Invetario, Costos, Reportes, Graficas">
    <meta name="author" content="CODER SOLUTIONS">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="{{ asset('images/icono.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/icono.png') }}" type="image/x-icon">

    <!--alertifyjs
    ================================================== -->
    <!-- CSS -->
    <script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form class="form" method="post" action="{{ route('login') }}">
                @csrf
                <img src="{{ asset('images/icono.png') }}" alt="">
                <h1>Ingresar</h1>
                <br>
                <input type="email" name="email" placeholder="Ingrese su email" />
                @include('alerts.feedback', ['field' => 'email'])
                <input type="password" name="password" placeholder="Ingrese su contraseña" />
                @include('alerts.feedback', ['field' => 'password'])
                <button>Iniciar sesion</button>
            </form>
        </div>
    </div>
</body>

</html>

