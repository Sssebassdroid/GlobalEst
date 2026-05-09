@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <p id="search-tagline">¡Logueate!</p>

    <div id="login-container" class="form-container-bigger">
        <form action="{{ url('/login') }}" method="POST" class="form-container" id="login-form">
            @csrf
            <input id="username-login" type="text" name="username" value="{{ old('username') }}" placeholder="BooleanSoX">            <input id="email-login" type="email" name="email" class="" placeholder="risetode@gmail.com">
            <input id="user-password" type="password" name="password" class="" placeholder="Contraseña segura">
            <input type="submit" value="Loguearme">
            <label for="tipo-registro">Con que te quieres registrar?</label>
            <select name="opcion-registro" id="tipo-registro">
                <option value="1">Usuario</option>
                <option value="2">Email</option>
            </select>
            <a href="{{ url('register') }}" class="brand-name">No tienes cuenta?</a>

            {{-- Comprobamos si hay algún error en la "bolsa" de errores --}}
            @if ($errors->has('login'))
            <div >
            {{ $errors->first('login') }}
            </div>

            @endif
            

        </form>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/forms.js'])
@endpush