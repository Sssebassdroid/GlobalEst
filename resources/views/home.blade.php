@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<div id="contenedor-buscador">
        <form action="/buscar" method="get" class="buscador">
            <input id="buscar-lugar" type="text" name="buscador" class="buscar" placeholder="Encuentra lugares y actividades...">
            <input id="buscar-fecha" type="date" name="buscador" class="buscar">
            <input id="cantidad-personas" type="number" name="buscador" min="0" step="1" class="buscar" placeholder="Personas" value="1">
            
            <button type="submit" id="lupa">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div id="mapamundi-holder">
        <div id="mapamundi"></div>
    </div>

</div>


@endsection

@push('scripts')
@endpush