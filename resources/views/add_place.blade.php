@extends('layouts.app')

@section('title', 'Seleccionar Itinerario')

@section('content')
    <p id="search-tagline">Añade lugares para tu nuevo Tour :)</p>

    <div id="agregar-rutas">
        
        <div id="mapamundi-holder">
            <div id="mapamundi"></div>
        </div>
        
        <div id="ventana-rutas-global">
            <div id="contenedor-buscador">
                
                <form action="" method="get" class="buscador" id="form-buscador">
                    <input id="place-name" type="text" name="buscador" class="buscar" placeholder="Ej: Via Bontempi 22, Perugia">
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
                        {{-- Se rellena dinámicamente con JS --}}
                    </tbody>
                </table>

                <div id="opciones-ruta">
                    {{-- El action apunta a processSelection, que solo redirige --}}
                    <form id="form-confirmar-ruta" action="{{ route('places.add') }}" method="POST">
                        @csrf
                        {{-- ID unificado: itinerario-temporal para que el JS lo encuentre --}}
                        <input type="hidden" name="itinerario_temporal" id="itinerario-temporal">
                        <button type="submit" class="btn-confirm">Confirmar Itinerario</button>
                    </form>
                    <button type="button" class="btn-cancel" onclick="limpiarMapa()">Eliminar Todo</button>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/mapamundi.js'])
@endpush