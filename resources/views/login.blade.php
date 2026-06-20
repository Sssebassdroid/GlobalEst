@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <p id="search-tagline">¡Logueate!</p>

    <div id="login-container" class="form-container-bigger">
        <form action="{{ url('/login') }}" method="POST" class="form-container" id="login-form">
            @csrf
            <label for="login">Escoge tu manera de loguearte:
            <input id="login" type="text" name="login" value="{{ old('login') }}" placeholder="Usuario o Email">
            </label>

            @if ($errors->has('login')){{ $errors->first('login') }}
            @endif

            <label for="password"> Introduce tu contraseña:
            <input id="password" type="password" name="password" placeholder="Contraseña">
            </label>
            @if ($errors->has('password')){{ $errors->first('password') }}
            @endif

            <button type="submit" >Loguearme </button>
            <a href="{{ route('register') }}" >No tienes cuenta?</a>
            <a href="{{ route('register') }}" >Olvidaste la contraseña?</a>




        </form>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/forms.js'])
@endpush
