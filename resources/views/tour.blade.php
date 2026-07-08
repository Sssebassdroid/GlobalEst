@extends('layouts.app')

@section('title', 'Crear Tour')

@section('content')
    <p id="search-tagline">¡Configura los detalles de tu Tour!</p>

    <div id="register-container" class="form-container-bigger">
        <form action="{{ route('tour.create') }}" method="POST" enctype="multipart/form-data" id="tour-form" class="form-container">
            @csrf

            <input id="tour_name" type="text" name="tour_name" placeholder="Nombre del Tour" required value="{{ old('tour_name') }}">
            <textarea id="description" name="description" placeholder="Descripción...">{{ old('description') }}</textarea>
            <input id="tour_price" type="number" name="tour_price" step="0.01" placeholder="Precio (€)" required value="{{ old('tour_price') }}">
            <input id="estimated_duration" type="time" name="estimated_duration" required value="{{ old('estimated_duration') }}">

            {{-- Categorías (Se gestionan por JS) --}}
            <input type="text" id="category-input" class="form-control" placeholder="Añadir categoría..." list="categories-list">
            <datalist id="categories-list">
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">
                @endforeach
            </datalist>
            <div id="selected-tags"></div>
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
                {{-- EL CONTENEDOR SE QUEDA VACÍO: JS LO RELLENARÁ --}}
                <tbody id="cuerpo-tabla"></tbody>
            </table>

            <input type="hidden" name="itinerary" id="itinerary">
            @if ($errors->any())
                <div class="error-box">
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
    @vite(['resources/js/tour.js'])
    @vite(['resources/js/category.js'])
@endpush
