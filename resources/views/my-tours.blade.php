@extends('layouts.app')

@section('title', 'Mis Tours')

@section('content')
    <p id="search-tagline">Gestión de tus Tours Publicados</p>

    <div id="register-container" class="form-container-bigger">
        <div class="form-container">
            <h3>Lista de Tours</h3>
            <table id="tabla-marcadores">
                <thead>x
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Duración</th>
                        <th>Categorías</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tours as $tour)
                        <tr>
                            <td>{{ $tour->id_tour }}</td>
                            <td><strong>{{ $tour->tour_name }}</strong></td>
                            <td>{{ $tour->tour_price }}€</td>
                            <td>{{ $tour->estimated_duration }}</td>
                            <td>
                                @foreach($tour->categories as $categories)
                                    <span">
                                        {{ $categories->name }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Aún no has publicado ningún tour.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <br>
            <a href="{{ route('places.add') }}" class="btn-primary">
                + Crear nuevo tour
            </a>
        </div>
    </div>
@endsection

@if(session('success'))
    <script>
        localStorage.removeItem('itinerario_temporal');
        console.log('Borrador de tour limpiado con éxito.');
    </script>
@endif