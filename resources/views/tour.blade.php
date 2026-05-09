@extends('layouts.app')

@section('title', 'Crear Tour')

@section('content')
    <p id="search-tagline">¡Configura los detalles de tu Tour!</p>

    <div id="register-container" class="form-container-bigger">
        {{-- La ruta debe apuntar al método que guardará el tour definitivo --}}
        <form action="{{ route('tour.create') }}" method="POST" enctype="multipart/form-data" id="tour-form" class="form-container">            @csrf
            
            <input id="tour_name" type="text" name="tour_name" placeholder="Nombre del Tour (ej: Paseo por Perugia)" required value="{{ old('tour_name') }}">
            
            
            <textarea id="description" name="description" ...>{{ old('description') }}</textarea>
            
            <input id="tour_price" type="number" name="tour_price" step="0.01" placeholder="Precio (€)" required value="{{ old('tour_price') }}">
            
            <input id="estimated_duration" type="time" name="estimated_duration" placeholder="Duración estimada" required value="{{ old('estimated_duration') }}">

    
            <input type="text" id="category-input" class="form-control" placeholder="Ej: Gastronomía, Historia..." list="categories-list" autocomplete="off">
    
            <datalist id="categories-list">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->name }}">
                @endforeach
            </datalist>

            <div id="selected-tags"></div>

{{-- ESTA ES LA PIEZA QUE FALTA --}}
<input type="hidden" name="categories_data" id="categories-data" value="[]">
            <label for="image">Imagen de portada:</label>
            <input type="file" name="image" id="image" accept="image/*" required>
            <hr>
            <h3>Itinerario Seleccionado</h3>
            <table id="tabla-marcadores">
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Lugar</th>
                    </tr>
                </thead>
                <tbody id="cuerpo-tabla">
                    {{-- Aquí se mostrarán los lugares que el usuario seleccionó en el mapa --}}
                    @if(isset($lugares))
                        @foreach($lugares as $index => $lugar)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lugar['display_name'] }}</td>
                                {{-- Pasamos los datos como inputs ocultos para que viajen al controlador --}}
                                <input type="hidden" name="puntos[{{$index}}][lat]" value="{{ $lugar['lat'] }}">
                                <input type="hidden" name="puntos[{{$index}}][long]" value="{{ $lugar['long'] }}">
                                <input type="hidden" name="puntos[{{$index}}][name]" value="{{ $lugar['name'] }}">
                                <input type="hidden" name="puntos[{{$index}}][display_name]" value="{{ $lugar['display_name'] }}">
                                <input type="hidden" name="puntos[{{$index}}][osm_id]" value="{{ $lugar['osm_id'] }}">
                                <input type="hidden" name="puntos[{{$index}}][osm_type]" value="{{ $lugar['osm_type'] }}">

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if ($errors->any())
    <div>
        <strong>¡Error de validación!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif            
            <input type="submit" value="Publicar Tour">
        </form>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/category.js'])
@endpush