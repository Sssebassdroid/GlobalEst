<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Globalest - @yield('title', 'Inicio')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body>

<header class="header">
    <nav class="nav">
        <div id="logo-container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/GlobalestLogo.png') }}" alt="logo Globalest" id="img-logo">
            </a>
            <a href="{{ url('/') }}" class="brand-name">
                <h1>Globalest</h1>
            </a>
        </div>

        <div id="contenedor-opciones">
    @auth
        <a href="{{ route('dashboard') }}" class="profile-link">
            {{ auth()->user()->isBusiness() ? 'Mis Tours' : 'Mis Viajes' }}
        </a>
    @endauth
    @guest
        <a href="{{route('login')}}"><i class="fa-solid fa-user"></i></a>    
    @endguest
        
</div>
    </nav>
</header>

<main class="main main-centered">
    @yield('content')
</main>

<footer>
    &copy; 2026 GlobalEst. Todos los derechos reservados.
</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@stack('scripts')
</body>
</html>