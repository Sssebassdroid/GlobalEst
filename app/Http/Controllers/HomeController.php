<?php

namespace App\Http\Controllers;
use App\Actions\GetFeaturedToursAction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;


class HomeController extends Controller
{
    public function display(GetFeaturedToursAction $getFeaturedTours) : Renderable
    {
        $tours = $getFeaturedTours->execute();
        return view('home', compact('tours'));
    }


}
