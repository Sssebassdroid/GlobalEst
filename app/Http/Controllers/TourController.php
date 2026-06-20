<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use App\Models\City;
use App\Models\PlaceAvailable;
use App\Models\Agency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTourRequest;
use App\Actions\CreateTourAction;
use App\DTOs\TourDTO;


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
        if ($request->has('itinerario_temporal') && is_string($request->input('itinerario_temporal'))) {
            $request->merge(['puntos' => json_decode($request->input('itinerario_temporal'), true)]);
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

    public function add(StoreTourRequest $request, CreateTourAction $creator): RedirectResponse
    {
        Log::info('Iniciando proceso de creación de tour', [
            'user_id' => auth()->id()
        ]);

        $imagePath = $request->file('image')->store('tours', 'public');
        Log::info('Imagen guardada temporalmente', ['path' => $imagePath]);

        $tourDTO = TourDTO::fromRequest($request);

        try {
            $tour = $creator->execute(
                $tourDTO,
                auth()->user()->agency->id_agency,
                $imagePath
            );

            Log::info('Tour creado exitosamente', [
                'tour_id' => $tour->id_tour,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('tour.index')->with('success', '¡Tour creado!');

        } catch (\Exception $e) {
            Log::error('Error al crear el tour', [
                'error'   => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            Storage::disk('public')->delete($imagePath);

            return back()->withInput()->with('error', 'Hubo un error al procesar el tour.');
        }
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
            // Sincroniza la tabla pivote de categorías
            $tour->categories()->sync($categoryIds);
        }
    }


}
