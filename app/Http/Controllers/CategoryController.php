<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class CategoryController extends Controller
{
    public function display()
    {

        $categories = Category::all();
        return view('tour', compact('categories'));

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
