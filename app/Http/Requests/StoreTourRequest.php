<?php

namespace App\Http\Requests;

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

        return $user !== null && method_exists($user, 'isBusiness') && $user->isBusiness();
    }

    /**
     * Obtiene las reglas de validación que se aplicarán a la petición.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tour_name' => 'required|string|min:3|max:150',
            'tour_price' => 'required|numeric|min:0',
            'description' => 'required|string|min:10|max:2000',
            'estimated_duration' => 'required|string', // Se valida como string para ser formateada en el DTO
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Máximo 2MB

            // Validamos que categories_data e itinerario_temporal existan y sean strings (ya que viajan como JSON)
            'categories_data' => 'required|string',
            'session_itinerary' => 'required|string',
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
            'tour_name' => 'nombre del tour',
            'tour_price' => 'precio',
            'description' => 'descripción',
            'estimated_duration' => 'duración estimada',
            'image' => 'imagen del tour',
            'categories_data' => 'categorías',
            'session_itinerary' => 'itinerario o puntos del mapa',
        ];
    }
}
