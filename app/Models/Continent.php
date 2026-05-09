<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    // Justificación: Laravel busca 'continents', tú tienes 'continent'
    protected $table = 'continent'; 
    
    // Justificación: No creamos las columnas de fecha en el SQL original
    public $timestamps = false; 
}