<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Importante para usar los logs



class TourController extends Controller
{


public function display()
{
    $user = auth()->user();

    // 1. Verificación de se    guridad
    if (!$user) {
        Log::warning('Intento de acceso a My-Tours sin sesión activa.', [
            'ip' => request()->ip()
        ]);
        return redirect()->route('login');
    }

    Log::info('Acceso a panel de gestión de tours.', [
        'user_id' => $user->id_user,
        'username' => $user->username
    ]);

    // 2. Limpiar sesiones de creación anteriores
    session()->forget('lugares_seleccionados');

    // 3. Lógica para empresas
    if ($user->isBusiness()) {
        try {
            // Buscamos la agencia del usuario
            $idAgencia = \DB::table('agency')->where('admin', $user->id_user)->value('id_agency');

            if (!$idAgencia) {
                Log::error('Error de integridad: Usuario con rol Business no tiene agencia vinculada.', [
                    'user_id' => $user->id_user
                ]);
                // Opcional: podrías abortar o redirigir con error
                return redirect()->route('home')->with('error', 'No se encontró tu perfil de agencia.');
            }

            // Obtenemos los tours con Eager Loading para optimizar (N+1)
            $tours = Tour::where('agency', $idAgencia)->with('categorias')->get();

            Log::info('Carga de tours completada para la agencia.', [
                'agency_id' => $idAgencia,
                'count' => $tours->count()
            ]);

            return view('my-tours', compact('tours'));

        } catch (\Exception $e) {
            Log::critical('Fallo sistémico al recuperar tours de agencia.', [
                'error' => $e->getMessage(),
                'user_id' => $user->id_user
            ]);
            return abort(500, 'Error interno al cargar tus tours.');
        }
    }

    // 4. Si no es empresa, mandarlo a sus viajes
    Log::info('Redirección de usuario personal a Mis Viajes.', ['user_id' => $user->id_user]);
    return redirect()->route('tourist.trips');
}

private function validateTourRequest(Request $request)
{
    return $request->validate([
        'tour_name'          => 'required|string|max:100',
        'tour_price'         => 'required|numeric|min:0',
        'description'        => 'required|string|max:1000',
        'estimated_duration' => 'required',
        'image'              => 'required|image|max:2048',
        'categories_data'    => 'required|string', 
        'puntos'             => 'required|array|min:1',
        'puntos.*.lat'       => 'required',
        'puntos.*.long'      => 'required',
        'puntos.*.display_name' => 'required|string',
    ]);
}








 public function add(Request $request)
{
    // 1. Verificación de sesión previa a todo
    if (!session()->has('lugares_seleccionados')) {
        \Log::error("Intento de creación sin lugares en sesión", 
        ['user' => auth()->user()->name]);
        return redirect('/places')->with('error', 'Sesión expirada. Selecciona los lugares de nuevo.');
    }

    // 2. Validación (Inyectamos el JSON de puntos si es necesario)
    if ($request->has('puntos_json')) {
        $request->merge(['puntos' => json_decode($request->input('puntos_json'), true)]);
    }

    try {
        $validated = $this->validateTourRequest($request);
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error("Fallo de validación", ['errors' => $e->errors()]);
        return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
    }

    // 3. Ejecución de la lógica de negocio
    try {
        $tour = DB::transaction(function () use ($request, $validated) {
            $path = $request->file('image')->store('tours', 'public');

            $user = auth()->user();

// Usamos $idAgencia para que coincida con la validación de abajo
$idAgencia = \DB::table('agency')->where('admin', $user->id_user)->value('id_agency');

if (!$idAgencia) {
    // Nota: Dentro de una transacción, es mejor lanzar una excepción para que haga rollback
    throw new \Exception('El usuario no tiene una agencia asignada.');
}

    $tour = Tour::create([
    'tour_name'          => $validated['tour_name'],
    'tour_price'         => $validated['tour_price'],
    'description'        => $validated['description'],
    'estimated_duration' => $validated['estimated_duration'],
    'image'              => $path,
    'agency'             => $idAgencia, // Ahora sí usamos la variable correcta
]);

            $this->processTourCategories($tour, $request->input('categories_data'));
            $this->persistItineraryFromSession($tour->id_tour);
            
            return $tour; // Devolvemos el tour creado
        });

        // 4. Limpieza y respuesta fuera de la transacción
        session()->forget('lugares_seleccionados');
        \Log::info("Tour publicado con éxito. ID: " . $tour->id_tour);
        
        // En lugar de redirect()->route('home')
return response()->json([
    'status' => 'success',
    'message' => '¡Tour publicado con éxito!',
    'redirect' => route('home')
]); 

    } catch (\Exception $e) {
        \Log::error("Fallo crítico al crear tour: " . $e->getMessage());
        return back()->with('error', 'Hubo un problema técnico. Reinténtalo.');
    }
}



protected function processTime(Tour $tour, $timeValue)
{
    try {
        // Usamos Carbon para normalizar el tiempo (por si acaso viene como H:i o H:i:s)
        $formattedTime = \Carbon\Carbon::parse($timeValue)->format('H:i:s');
        
        $tour->update([
            'estimated_duration' => $formattedTime
        ]);
    } catch (\Exception $e) {
        \Log::warning("Formato de tiempo inválido: " . $timeValue);
    }
}



   protected function validateMapPoints(Request $request)
{
    // Decodificamos el JSON que viene del input oculto
    $puntos = json_decode($request->input('puntos_json'), true);
    
    // Inyectamos el array de vuelta en el request para que validate() lo vea
    $request->merge(['puntos' => $puntos]);
    
    return $request->validate([
        'puntos' => 'required|array|min:1',
        'puntos.*.id_place' => 'required|integer|exists:places_available,id_place',
        'puntos.*.lat'      => 'required|numeric',
        'puntos.*.long'     => 'required|numeric',
        'puntos.*.name'     => 'required|string',
    ]);
}


    

    protected function processTourCategories(Tour $tour, string $jsonData)
    {
        $categoryNames = json_decode($jsonData, true);
        $categoryIds = [];

        if (is_array($categoryNames)) {
            foreach ($categoryNames as $name) {
                $category = Category::firstOrCreate(
                    ['name' => mb_strtolower(trim($name))], 
                    ['name' => trim($name)]
                );
                $categoryIds[] = $category->id_category;
            }
            $tour->categorias()->sync($categoryIds);
        }
    }


protected function persistItineraryFromSession(int $tourId)
{
    $puntos = session('lugares_seleccionados');
    if (!$puntos) return;

    foreach ($puntos as $index => $punto) {
        
        // 1. Resolvemos el Continente (Nivel máximo)
        $continentDB = \App\Models\Continent::firstOrCreate(
            ['name' => 'Europa'] // O traerlo de la API si está disponible
        );

        // 2. Resolvemos el País vinculándolo al Continente
        $nombrePais = $punto['country_name'] ?? 'Italia';
        $countryDB = \App\Models\Country::firstOrCreate(
            ['name' => $nombrePais],
            ['continent' => $continentDB->id_continent] // <-- Aquí se soluciona tu error actual
        );

        // 3. Resolvemos la Ciudad vinculándola al País
        $nombreCiudad = $punto['city_name'] ?? 'Perugia'; 
        $cityDB = \App\Models\City::firstOrCreate(
            ['name' => $nombreCiudad],
            ['country' => $countryDB->id_country]
        );

        // 3. Resolvemos el lugar vinculado a esa ciudad
        $lugarDB = \App\Models\PlaceAvailable::updateOrCreate(
            ['display_name' => $punto['display_name']], 
            [
                'name'      => $punto['name'],
                'osm_id'    => $punto['osm_id'],
                'osm_type'    => $punto['osm_type'],
                'latitude'  => $punto['lat'],
                'longitude' => $punto['long'],
                'city'      => $cityDB->id_city
            ]
        );

        // 4. Insertamos en la tabla pivote
        \DB::table('places_tour')->insert([
            'tour'           => $tourId,
            'places'         => $lugarDB->id_place,
            'order_position' => $index + 1,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}



public function myTours()
{
    $user = auth()->user();
    
    // Buscamos la agencia del usuario
    $idAgencia = \DB::table('agency')->where('admin', $user->id_user)->value('id_agency');

    // Obtenemos los tours de esa agencia con sus categorías (usando la relación que creamos)
    $tours = \App\Models\Tour::where('agency', $idAgencia)->with('categorias')->get();

    return view('my-tours', compact('tours'));
}
}