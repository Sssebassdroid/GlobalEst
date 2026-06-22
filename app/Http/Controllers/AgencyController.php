<?php

namespace App\Http\Controllers; // 👈 Verifica que esté escrito tal cual

use Illuminate\Routing\Controller;

class AgencyController extends Controller
{
    public function create()
    {
        return view('agency.setup'); // O la vista de tu formulario
    }
}
