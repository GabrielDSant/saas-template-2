<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GerarImagemRequest extends FormRequest
{
    public function authorize()
    {
        // Permite apenas usuários autenticados
        return auth()->check();
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:png,jpg,svg,webp,gif|max:2048',
            'styles' => 'required|string',
        ];
    }
}
