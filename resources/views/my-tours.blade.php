@extends('layouts.app')

@section('title', 'Mis Tours')

@section('content')
    <p id="search-tagline">Gestión de tus Tours Publicados</p>

    <div id="register-container" class="form-container-bigger">
        <div class="form-container">
            <h3>Lista de Tours Publicados</h3>
            
            <table id="tabla-marcadores">
                <thead>
                    <tr>
                        <th>Vista Previa</th>
                        <th>Información General</th>
                        <th>Precio y Tiempo</th>
                        <th>Categorías</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tours as $tour)
                        <tr>
                            {{-- 1. Visualización de Imagen --}}
                            <td>
                                @if($tour->image)
                               <!--      <img src="{{ asset('storage/' . $tour->image) }}" 
                                         alt="{{ $tour->tour_name }}" > -->
                                @else
                                    <div>
                                        Sin imagen
                                    </div>
                                @endif
                            </td>

                            {{-- 2. Identificación y Descripción --}}
                            <td>
                                <strong>{{ $tour->tour_name }}</strong><br>
                                <small>
                                    {{ $tour->description }}
                                </small>
                            </td>

                            {{-- 3. Métricas del Tour --}}
                            <td>
                                <span class="tag-price">{{ number_format($tour->tour_price, 2) }}€</span><br>
                                <small>⏱ {{ $tour->estimated_duration }}</small>
                            </td>

                            {{-- 4. Categorías con estilo de etiquetas --}}
                            <td>
                                @foreach($tour->categories as $category)
                                    <span class="tag-category">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </td>

                            {{-- 5. Acciones --}}
                            <td>
                                <a href="#" class="btn-confirm">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                Aún no has publicado ningún tour.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <br>
            <div>
                <a href="{{ route('places.add') }}" class="btn-confirm">
                    + Crear nuevo tour
                </a>
            </div>
        </div>
    </div>
@endsection

@if(session('success'))
    <script>
        // Limpiamos el borrador solo si el servidor confirma el éxito
        localStorage.removeItem('itinerario_temporal');
        console.log('Ecosistema GlobalEst: LocalStorage purgado tras persistencia exitosa.');
    </script>
@endif