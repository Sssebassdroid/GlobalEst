@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <p id="search-tagline">¡Encuentra las <strong>mejores experiencias</strong>
        <br> para ti!</p>

    <div id="contenedor-buscador">
        <form action="/buscar" method="get" class="buscador">
            <input id="buscar-lugar" type="text" name="buscador-lugar" class="buscar" placeholder="Encuentra lugares y actividades...">
            <input id="buscar-fecha" type="date" name="buscador-fecha" class="buscar">
            <input id="cantidad-personas" type="number" name="cantidad-personas" min="0" step="1" class="buscar" placeholder="Personas" value="1">

            <button type="submit" id="lupa">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div id="mapamundi-holder">
        <div id="mapamundi"></div>
    </div>


    <div class="tours-grid">
        @forelse($tours as $tour)
            <div class="tour-card">
                <div class="tour-header">
                    <img src="{{ asset('storage/' . $tour->image) }}" alt="Imagen de {{ $tour->tour_name }}">
                    <span class="price-tag">{{ $tour->tour_price }}€</span>
                </div>

                <div class="tour-body">
                    <h3>{{ $tour->tour_name }}</h3>
                    <p class="agency-name">Publicado por: {{ $tour->agencia_relacion->agency_name }}</p>

                    <div class="categories-container">
                        @foreach($tour->categorias as $cat)
                            <span class="category-pill">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="tour-footer">
                    <a href="{{ route('tour.show', $tour->id_tour) }}" class="btn-more">Explorar Tour</a>
                </div>
            </div>
        @empty
            <p>No hay tours disponibles en este momento.</p>
        @endforelse
</div>






@endsection
@push('scripts')
    @vite(['resources/js/search-tours.js'])
<script>
    document.getElementById('buscar-fecha').valueAsDate = new Date();
</script>
@endpush
