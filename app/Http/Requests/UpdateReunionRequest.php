<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReunionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('reunion'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'asistentes_internos' => ['nullable', 'array'],
            'asistentes_internos.*' => ['exists:users,id'],
            'asistentes_externos' => ['nullable', 'array'],
            'asistentes_externos.*.nombre' => ['required_with:asistentes_externos', 'string', 'max:255'],
            'asistentes_externos.*.email' => ['nullable', 'email', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'asistentes_internos.*.exists' => 'Uno de los usuarios seleccionados no existe.',
            'asistentes_externos.*.nombre.required_with' => 'El nombre del asistente externo es obligatorio.',
            'asistentes_externos.*.email.email' => 'El email del asistente externo debe ser válido.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo' => trim($this->titulo ?? ''),
            'ubicacion' => $this->ubicacion ? trim($this->ubicacion) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
        ]);
    }
}
