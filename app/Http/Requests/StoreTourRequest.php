<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta petición.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $user = $this->user();

        // Permitir únicamente a usuarios autenticados que tengan una agencia asociada.
        // Esto evita que peticiones anónimas o usuarios sin agencia creen tours.
        return $user !== null && isset($user->agency) && $user->agency->id !== null;
    }

    /**
     * Obtiene las reglas de validación que se aplicarán a la petición.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|min:10|max:2000',
            'duration' => 'required|string',
            'capacity' => 'required|integer|min:2',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categories_list' => 'required|string',
            'itinerary' => 'required|string',
        ];
    }

    /**
     * Personaliza los nombres de los atributos para los mensajes de error.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre del tour',
            'price' => 'precio',
            'description' => 'descripción',
            'duration' => 'duración',
            'capacity' => 'capacidad',
            'image' => 'imagen del tour',
            'categories_list' => 'categorías',
            'itinerary' => 'itinerario o puntos del mapa',
        ];
    }
}
