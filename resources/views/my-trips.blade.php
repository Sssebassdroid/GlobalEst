@extends('layouts.app')

@section('title', 'Mis Tours')

@section('content')
    <p id="search-tagline">Gestión de tus Tours Publicados</p>

    <div id="register-container" class="form-container-bigger">
        <div class="form-container">
            <h3>Lista de Tours</h3>
            <table id="tabla-marcadores">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Duración</th>
                        <th>Categorías</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            
        </div>
    </div>
@endsection