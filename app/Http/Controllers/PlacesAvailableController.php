<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlacesAvailableController extends Controller
{
    public function display()
    {
        return view('add_place');
    }


    public function validatePlaceAvailable(Request $request)
{
    try {
        // Ejecutamos la validación
        $validated = $request->validate([
            'name'         => 'required|string|max:255|unique:places_available,name',
            'display_name' => 'required|string',
            'osm_id'       => 'required|integer|unique:places_available,osm_id',
            'osm_type'     => 'required|string|max:50',
            'latitud'      => 'required|numeric|between:-90,90',
            'longitud'     => 'required|numeric|between:-180,180',
            'city'         => 'required|integer|exists:city,id_city', // ¡Importante validar la FK!
        ]);

        // Si la validación pasa, creamos una instancia (sin guardar todavía) o la devolvemos
        // En ingeniería, esto se llama "Data Transfer Object" (DTO) simplificado
        return new \App\Models\PlaceAvailable([
            'name'         => $validated['name'],
            'display_name' => $validated['display_name'],
            'osm_id'       => $validated['osm_id'],
            'osm_type'     => $validated['osm_type'],
            'latitude'     => $validated['latitud'],  // Ojo: en tu esquema es 'latitude'
            'longitude'    => $validated['longitud'], // Ojo: en tu esquema es 'longitude'
            'city'         => $validated['city'],
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Si falla, registramos el log de error antes de que Laravel redirija
        Log::error("Fallo al validar un nuevo lugar en Perugia", [
            'usuario_id' => auth()->id(),
            'errores'    => $e->errors(),
            'input'      => $request->all()
        ]);

        // Re-lanzamos la excepción para que Laravel maneje la respuesta al cliente
        throw $e;
    }
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255|unique:places_available,name',
            'display_name' => 'required|string',
            'osm_id'       => 'required|integer|unique:places_available,osm_id',
            'osm_type'     => 'required|string|max:50',
            'latitud'      => 'required|numeric|between:-90,90',
            'longitud'     => 'required|numeric|between:-180,180',
        ]);

        PlaceAvailable::create($validated);

        return redirect()->back()->with('success', '¡Lugar guardado en el sistema correctamente!');
    }


   public function saveOnSession(Request $request)
    {
        // 1. Decodificamos el JSON que envía tu JS
        $puntos = json_decode($request->input('puntos_json'), true);

        // 2. Validación rápida
        if (!$puntos || count($puntos) === 0) {
            return back()->with('error', 'No se han seleccionado lugares.');
        }

        // 3. Guardamos en sesión
        session(['lugares_seleccionados' => $puntos]);

        // 4. Redirigimos a la fase final
        return redirect()->route('tour.create');
    }





    protected function persistItineraryFromSession(int $tourId)
{
    $puntos = session('lugares_seleccionados');

    foreach ($puntos as $index => $punto) {
        
        // A. Normalización de Ciudad
        $nombreCiudad = trim($punto['city'] ?? 'Unknown');

        $ciudadDB = \App\Models\City::firstOrCreate(
            ['name' => $nombreCiudad],
            ['country' => 1 ] 
        );

        // B. Upsert del Lugar con datos de la API
        $lugarDB = \App\Models\PlaceAvailable::updateOrCreate(
            ['osm_id' => $punto['osm_id']], 
            [
                'name'         => $punto['name'],
                'display_name' => $punto['display_name'] ?? $punto['name'],
                'latitude'     => $punto['lat'],
                'longitude'    => $punto['long'],
                'osm_type'     => $punto['osm_type'] ?? null,
                'osm_ id'     => $punto['osm_id'] ?? null,
                'importance'   => $punto['importance'] ?? 0,
                'city'         => $ciudadDB->id_city
            ]
        );

        // C. Registro en el itinerario del Tour
        \DB::table('places_tour')->insert([
            'tour'           => $tourId,
            'places'         => $lugarDB->id_place,
            'order_position' => $index + 1
        ]);
    }
}
    


}