<?php

namespace App\Http\Controllers;

use App\Actions\GetAgencyToursAction;
use App\Services\TourService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTourRequest;
use App\DTOs\TourDTO;


class TourController extends Controller
{

    public function display(GetAgencyToursAction $getAgencyTours)
    {
        try {
            $tours = $getAgencyTours->execute(auth()->user()->id);
            return view('my-tours', compact('tours'));


        } catch (ModelNotFoundException $e) {
            Log::error('Error de integridad: Perfil de agencia no encontrado para el usuario.', [
                'user_id' => auth()->user()->id_user
            ]);
            return redirect()->route('agency.setup');

        } catch (Exception $e) {
            Log::critical('Fallo sistémico en display My-Tours.', ['error' => $e->getMessage()]);
            return back()->withErrors($e->getMessage());
        }
    }

    public function add(StoreTourRequest $request, TourService $tourService): RedirectResponse
    {
        Log::info('Iniciando proceso de creación de tour', ['user_id' => auth()->id()]);

        $imagePath = $request->file('image')->store('tours', 'public');

        $tourDTO = TourDTO::fromRequest($request);
        $agencyId = auth()->user()->agency->id;
        $categoriesJson = $request->input('categories_data');

        try {
            $tourService->createFullTour($tourDTO, $agencyId, $imagePath, $categoriesJson);
            return redirect()->route('tour.index')->with('success', '¡Tour creado exitosamente!');

        } catch (Exception $e) {
            Log::error('Error en TourController::add', ['error' => $e->getMessage()]);

            Storage::disk('public')->delete($imagePath);

            return back()->withInput()->with('error', 'Hubo un error al crear el tour.');
        }
    }

}
