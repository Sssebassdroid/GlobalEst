<?php

namespace App\Http\Controllers;

use App\Models\Category; // Importante para que funcione el display
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


/**
 * Controlador de categoria
 */
class CategoryController extends Controller
{
    public function display() : View
{

    /**
     *1. Recibe como parámetros todas las categorias disponibles en la BBDD
     *2. Devuelve una vista con las categorias.
     */

    $categories = Category::all();
    return view('tour', compact('categories'));
}
    public function store(Request $request) : RedirectResponse
    {
        /**
         * 1. Toma una petición para crear una categoria nueva
         *    Dentro del modelo Category
         */
        Category::create($request->validated());

        return redirect()->back()->with('success', 'Categoría creada con éxito');
    }

}
