<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use App\Models\City;
use App\Models\PlaceAvailable;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    /**
     * Muestra el panel de gestión de la empresa.
     */
    public function display()
    {
        $user = auth()->user();

        if (!$user) {
            Log::warning('Intento de acceso a My-Tours sin sesión activa.');
            return redirect()->route('login');
        }

        if ($user->isBusiness()) {
            try {
                // Buscamos la agencia usando el modelo y la columna correcta (user_id)
                $agencia = Agency::where('user_id', $user->id_user)->first();

                if (!$agencia) {
                    Log::error('Integridad: Usuario Business sin agencia vinculada.', ['user_id' => $user->id_user]);
                    return redirect()->route('home')->with('error', 'No se encontró tu perfil de agencia.');
                }

                // Eager Loading: Traemos los tours y sus categorías de golpe
                $tours = Tour::where('agency_id', $agencia->id_agency)->with('categories')->get();

                Log::info('Carga de tours completada.', ['agency_id' => $agencia->id_agency, 'count' => $tours->count()]);
                
                return view('my-tours', compact('tours'));

            } catch (\Exception $e) {
                Log::critical('Fallo sistémico en display My-Tours.', ['error' => $e->getMessage()]);
                return abort(500, 'Error interno al cargar tus tours.');
            }
        }

        Log::info('Redirección de turista a Mis Viajes.', ['user_id' => $user->id_user]);
        return redirect()->route('tourist.trips');
    }

    /**
     * Valida el JSON y los campos del Request.
     */
    private function validateTourPayload(Request $request): array
    {
        // 1. Marshalling: Si el JS envía un string JSON, lo inyectamos como array en 'puntos'
        if ($request->has('puntos_json') && is_string($request->input('puntos_json'))) {
            $request->merge(['puntos' => json_decode($request->input('puntos_json'), true)]);
        }

        return $request->validate([
            'tour_name'          => 'required|string|max:100',
            'tour_price'         => 'required|numeric|min:0',
            'description'        => 'required|string|max:1000',
            'estimated_duration' => 'required',
            'image'              => 'required|image|max:2048',
            'categories_data'    => 'required|string', 
            
            // 2. Validación estructural de los datos geográficos
            'puntos'             => 'required|array|min:1',
            'puntos.*.lat'       => 'required|numeric',
            'puntos.*.long'      => 'required|numeric',
            'puntos.*.display_name' => 'required|string',
            'puntos.*.name'      => 'required|string',
            'puntos.*.osm_id'    => 'required|numeric',
            'puntos.*.osm_type'  => 'required|string'
        ]);
    }

    /**
     * Publica un Tour (Flujo 100% Stateless).
     */
    public function add(Request $request)
    {
        Log::info('Inicio de publicación de tour vía JSON.', ['user_id' => auth()->id()]);

        try {
            // Procesamos y validamos la entrada
            $validated = $this->validateTourPayload($request);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Fallo de validación JSON.', ['errors' => $e->errors()]);
            
            // Si es una petición AJAX/Fetch, devolvemos JSON con los errores
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            $tour = DB::transaction(function () use ($request, $validated) {
                
                $agencia = Agency::where('user_id', auth()->id())->firstOrFail();
                $path = $request->file('image')->store('tours', 'public');

                $tour = Tour::create([
                    'tour_name'          => $validated['tour_name'],
                    'tour_price'         => $validated['tour_price'],
                    'description'        => $validated['description'],
                    'estimated_duration' => \Carbon\Carbon::parse($validated['estimated_duration'])->format('H:i:s'),
                    'image'              => $path,
                    'agency_id'          => $agencia->id_agency, 
                ]);

                // Procesamos categorías e itinerario usando los datos ya validados
                $this->processTourCategories($tour, $validated['categories_data']);
                $this->processItinerary($tour->id_tour, $validated['puntos']);
                
                return $tour;
            });

            Log::info("Tour guardado exitosamente.", ['tour_id' => $tour->id_tour]);
            
            return response()->json([
                'status' => 'success',
                'message' => '¡Tour publicado con éxito!',
                'redirect' => route('my-tours')
            ]); 

        } catch (\Exception $e) {
            Log::critical("Fallo en transacción: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error interno del servidor.'], 500);
        }
    }
    /**
     * Vincula las categorías (Grado 3).
     */
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
            // Sincroniza la tabla pivote de categorías
            $tour->categorias()->sync($categoryIds);
        }
    }

    /**
     * Construye el itinerario delegando la ubicación al modelo City.
     */
    
}