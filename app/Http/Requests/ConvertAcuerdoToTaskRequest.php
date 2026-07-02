<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvertAcuerdoToTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Tarea::class);
    }

    public function rules(): array
    {
        return [
            'tipo' => ['required', 'in:mejora,soporte'],
            'prioridad' => ['required', 'in:alta,media,baja'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'El tipo de tarea es obligatorio.',
            'tipo.in' => 'El tipo debe ser: mejora o soporte.',
            'prioridad.required' => 'La prioridad es obligatoria.',
            'prioridad.in' => 'La prioridad debe ser: alta, media o baja.',
        ];
    }
}
