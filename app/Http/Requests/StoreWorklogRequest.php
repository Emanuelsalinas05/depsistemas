<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorklogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Worklog::class);
    }

    public function rules(): array
    {
        return [
            'tarea_id' => ['required', 'exists:tareas,id'],
            'fecha' => ['required', 'date'],
            'minutos' => ['required', 'integer', 'min:1', 'max:1440'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'source' => ['required', 'in:manual,timer,import'],
        ];
    }

    public function messages(): array
    {
        return [
            'tarea_id.required' => 'La tarea es obligatoria.',
            'tarea_id.exists' => 'La tarea seleccionada no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'minutos.required' => 'Los minutos son obligatorios.',
            'minutos.integer' => 'Los minutos deben ser un número entero.',
            'minutos.min' => 'Los minutos deben ser al menos 1.',
            'minutos.max' => 'Los minutos no pueden exceder 1440 (24 horas).',
            'source.required' => 'El origen es obligatorio.',
            'source.in' => 'El origen debe ser: manual, timer o import.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled('tarea_id')) {
                $tarea = \App\Models\Tarea::find($this->tarea_id);
                if ($tarea && !$this->user()->proyectos()->where('proyectos.id', $tarea->proyecto_id)->exists()) {
                    $validator->errors()->add('tarea_id', 'No eres miembro del proyecto de esta tarea.');
                }
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tarea_id' => $this->tarea_id ? (int) $this->tarea_id : null,
            'minutos' => $this->minutos ? (int) $this->minutos : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'source' => $this->source ?? 'manual',
        ]);
    }
}
