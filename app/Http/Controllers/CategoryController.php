<?php

namespace App\Http\Controllers;

use App\Models\Category; // Importante para que funcione el display
use Illuminate\Http\Request;


class CategoryController extends Controller
{
  public function display()
{
    
    $categorias = Category::all(); //<- De la categoria tablas, agarreme todas las que hay.
    return view('tour', compact('categorias'));
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