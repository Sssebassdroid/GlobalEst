@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <p id="search-tagline">Añade un lugar para tu empresa :)</p>

    <div id="agregar-rutas">
        
        <div id="mapamundi-holder">
            <div id="mapamundi"></div>
        </div>
        
        <div id="ventana-rutas-global">
            <div id="contenedor-buscador">
                
                <form action="/buscar" method="get" class="buscador">
                    <input id="place-name" type="text" name="buscador" class="buscar" placeholder="Via Bontempi 22">
                    <button type="submit" id="lupa">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <table id="tabla-marcadores">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Lugar</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo-tabla">
                    </tbody>
                </table>

                <div id="opciones-ruta">
    <form id="form-confirmar-ruta" action="{{ route('places.add') }}" method="POST">
        @csrf
        <input type="hidden" name="itinerario_temporal" id="puntos-json">
        <button type="submit" class="btn-confirm">Confirmar Itinerario</button>
    </form>
    <button type="button" class="btn-cancel" onclick="limpiarMapa()">Eliminar Todo</button>
</div>

            </div>
        </div>


    </div>
@endsection

@push('scripts')
    @vite(['resources/js/mapamundi.js'])
@endpush