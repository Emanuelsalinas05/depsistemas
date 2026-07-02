<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorklogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('worklog'));
    }

    public function rules(): array
    {
        return [
            'fecha' => ['required', 'date'],
            'minutos' => ['required', 'integer', 'min:1', 'max:1440'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'source' => ['required', 'in:manual,timer,import'],
        ];
    }

    public function messages(): array
    {
        return [
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'minutos' => $this->minutos ? (int) $this->minutos : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'source' => $this->source ?? 'manual',
        ]);
    }
}
