<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class AgencyController extends Controller
{
    public function create()
    {
        return view('agency.setup');
    }
}
