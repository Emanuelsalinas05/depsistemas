<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReunionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Reunion::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'proyecto_id' => ['nullable', 'exists:proyectos,id'],
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
            'proyecto_id.exists' => 'El proyecto seleccionado no existe.',
            'asistentes_internos.*.exists' => 'Uno de los usuarios seleccionados no existe.',
            'asistentes_externos.*.nombre.required_with' => 'El nombre del asistente externo es obligatorio.',
            'asistentes_externos.*.email.email' => 'El email del asistente externo debe ser válido.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Verificar que el usuario es miembro del proyecto si se especifica
            if ($this->filled('proyecto_id')) {
                $proyecto = \App\Models\Proyecto::find($this->proyecto_id);
                if ($proyecto && !$this->user()->proyectos()->where('proyectos.id', $proyecto->id)->exists()) {
                    $validator->errors()->add('proyecto_id', 'No eres miembro de este proyecto.');
                }
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo' => trim($this->titulo ?? ''),
            'proyecto_id' => $this->proyecto_id ? (int) $this->proyecto_id : null,
            'ubicacion' => $this->ubicacion ? trim($this->ubicacion) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
        ]);
    }
}
