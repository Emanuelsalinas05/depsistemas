<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Tarea::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'proyecto_id' => ['required', 'exists:proyectos,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['required', 'in:feature,bug,soporte,mejora,doc'],
            'prioridad' => ['required', 'in:alta,media,baja'],
            'estado' => ['required', 'in:nuevo,en_curso,en_revision,listo_release,cerrado'],
            'asignado_a' => ['nullable', 'exists:users,id'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'estimacion_horas' => ['nullable', 'numeric', 'min:0', 'max:9999.99'],
            'progreso' => ['nullable', 'integer', 'min:0', 'max:100'],
            'evidencia_url' => ['nullable', 'url', 'max:255'],
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
            'proyecto_id.required' => 'El proyecto es obligatorio.',
            'proyecto_id.exists' => 'El proyecto seleccionado no existe.',
            'titulo.required' => 'El título es obligatorio.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser: feature, bug, soporte, mejora o doc.',
            'prioridad.required' => 'La prioridad es obligatoria.',
            'prioridad.in' => 'La prioridad debe ser: alta, media o baja.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: nuevo, en_curso, en_revision, listo_release o cerrado.',
            'asignado_a.exists' => 'El usuario asignado no existe.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estimacion_horas.numeric' => 'La estimación debe ser un número.',
            'estimacion_horas.min' => 'La estimación no puede ser negativa.',
            'progreso.integer' => 'El progreso debe ser un número entero.',
            'progreso.min' => 'El progreso no puede ser menor a 0.',
            'progreso.max' => 'El progreso no puede ser mayor a 100.',
            'evidencia_url.url' => 'La URL de evidencia debe ser una URL válida.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Verificar que el usuario es miembro del proyecto
            if ($this->filled('proyecto_id')) {
                $proyecto = \App\Models\Proyecto::find($this->proyecto_id);
                if ($proyecto && !$this->user()->proyectos()->where('proyectos.id', $proyecto->id)->exists()) {
                    $validator->errors()->add('proyecto_id', 'No eres miembro de este proyecto.');
                }
            }

            // Soporte solo puede crear tareas tipo soporte
            if ($this->user()->hasRole('soporte') && $this->tipo !== 'soporte') {
                $validator->errors()->add('tipo', 'Solo puedes crear tareas de tipo soporte.');
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
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'proyecto_id' => $this->proyecto_id ? (int) $this->proyecto_id : null,
            'asignado_a' => $this->asignado_a ? (int) $this->asignado_a : null,
            'fecha_inicio' => $this->fecha_inicio ?: null,
            'fecha_fin' => $this->fecha_fin ?: null,
            'estimacion_horas' => $this->estimacion_horas ? (float) $this->estimacion_horas : null,
            'progreso' => $this->progreso ? (int) $this->progreso : 0,
            'evidencia_url' => $this->evidencia_url ? trim($this->evidencia_url) : null,
        ]);
    }
}
