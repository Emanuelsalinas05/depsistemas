<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcuerdoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Acuerdo::class);
    }

    public function rules(): array
    {
        return [
            'reunion_id' => ['nullable', 'exists:reuniones,id'],
            'proyecto_id' => ['nullable', 'exists:proyectos,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'detalle' => ['nullable', 'string'],
            'responsable_id' => ['nullable', 'exists:users,id'],
            'fecha_compromiso' => ['nullable', 'date'],
            'estatus' => ['required', 'in:pendiente,en_progreso,cumplido,cancelado'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'reunion_id.exists' => 'La reunión seleccionada no existe.',
            'proyecto_id.exists' => 'El proyecto seleccionado no existe.',
            'responsable_id.exists' => 'El responsable seleccionado no existe.',
            'fecha_compromiso.date' => 'La fecha de compromiso debe ser una fecha válida.',
            'estatus.required' => 'El estatus es obligatorio.',
            'estatus.in' => 'El estatus debe ser: pendiente, en_progreso, cumplido o cancelado.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo' => trim($this->titulo ?? ''),
            'detalle' => $this->detalle ? trim($this->detalle) : null,
            'reunion_id' => $this->reunion_id ? (int) $this->reunion_id : null,
            'proyecto_id' => $this->proyecto_id ? (int) $this->proyecto_id : null,
            'responsable_id' => $this->responsable_id ? (int) $this->responsable_id : null,
            'estatus' => $this->estatus ?? 'pendiente',
        ]);
    }
}
