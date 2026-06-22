<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Importante para que funcione el display


class CategoryController extends Controller
{
    public function display()
    {

        $categorias = Category::all();
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
