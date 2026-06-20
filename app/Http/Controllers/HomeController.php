<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use App\Models\Tour;
use Illuminate\Routing\Controller;


class HomeController extends Controller
{
    public function display() : Renderable
    {
        $tours = Tour::latestFeatured()->get();
        return view('home', compact('tours'));
    }


}
