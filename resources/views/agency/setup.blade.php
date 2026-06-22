@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <p id="search-tagline">¡Regístrate!</p>

    <div id="register-container" class="form-container-bigger">
        {{-- Cambia 'xx' por la ruta de procesamiento, ej: route('register.store') --}}
        <form action="{{ url('/register') }}" method="POST" class="form-container" id="register-form">
            @csrf

            <input id="username" type="text" name="username" placeholder="BooleanSoX" required>
            <input id="name" type="text" name="name" placeholder="Sebastian" required>
            <input id="first-last-name" type="text" name="first_last_name" placeholder="Tovar" required>
            <input id="second-last-name" type="text" name="second_last_name" placeholder="Delgado">
            <input id="email" type="email" name="email" placeholder="risetode@gmail.com" required>

            <input id="password" type="password" name="password" placeholder="Contraseña segura" required>
            <input id="confirm-password" type="password" name="password_confirmation" placeholder="Confirma contraseña..." required>

            <div id="contenedor-errores">
                {{-- Aquí JS insertará el mensaje si las claves no coinciden --}}
                <ul id="lista-errores-js"></ul>

                {{-- Errores que vienen del Servidor (Laravel) --}}
                @if ($errors->any())
                    <script>
                        // Si hay errores de Laravel, forzamos que el contenedor se vea al cargar
                        document.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('contenedor-errores').style.display = 'block';
                        });
                    </script>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>




            <label for="tipo-usuario">¿Qué tipo de usuario eres?</label>
            <select name="role_id" id="tipo-usuario">
                <option value="" selected disabled>Selecciona una opción</option>
            </select>

            <input type="submit" value="Registrarme">
        </form>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/forms.js'])
@endpush
