<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcuerdoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('acuerdo'));
    }

    public function rules(): array
    {
        return [
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
            'responsable_id' => $this->responsable_id ? (int) $this->responsable_id : null,
        ]);
    }
}
