<?php

namespace App\Http\Controllers;

use App\Models\Category; // Importante para que funcione el display
use Illuminate\Http\Request;
use App\Models\Tour;


class CategoryController extends Controller
{
  public function display()
{
    if (!session()->has('lugares_seleccionados')) {


        $user = auth()->user();

        \Log::warning('Acceso no autorizado a /create-tour: El usuario intentó acceder sin itinerario.', [
            'nombre' => $user->name,
            'rol'    => $user->RoleType->type,

        ]);

        return redirect('/places') // Tu vista del mapa
               ->with('error', 'Debes seleccionar al menos un lugar antes de configurar el tour.');
    }

    $categorias = Category::all(); //<- De la categoria tablas, agarreme todas las que hay.
    $lugares = session('lugares_seleccionados'); // <- En session recuperamos los lugares.

    return view('tour', compact('categorias', 'lugares'));
}







    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:category,name',
        ]);

        Category::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Categoría creada con éxito');
    }


    
}