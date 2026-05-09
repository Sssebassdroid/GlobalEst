<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;


class HomeController extends Controller
{
  public function display()
{

    $tours = Tour::with(['categorias', 'agencia']) // Eager loading para optimizar
                ->latest() // Los más nuevos primero
                ->take(10) // AQUÍ está el límite de 10
                ->get();

    return view('home', compact('tours'));

}

    
}