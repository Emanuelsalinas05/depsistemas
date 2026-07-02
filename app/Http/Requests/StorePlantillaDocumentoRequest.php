<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantillaDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('manage', \App\Models\PlantillaDocumento::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:manual_tecnico,manual_usuario,runbook,adr,postmortem'],
            'formato' => ['required', 'in:markdown,html'],
            'contenido_template' => ['required', 'string'],
            'version' => ['nullable', 'string', 'max:50'],
            'activa' => ['sometimes', 'boolean'],
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
            'nombre.required' => 'El nombre de la plantilla es obligatorio.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser: manual_tecnico, manual_usuario, runbook, adr o postmortem.',
            'formato.required' => 'El formato es obligatorio.',
            'formato.in' => 'El formato debe ser: markdown o html.',
            'contenido_template.required' => 'El contenido de la plantilla es obligatorio.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim($this->nombre ?? ''),
            'version' => $this->version ? trim($this->version) : null,
            'activa' => $this->has('activa') ? (bool) $this->activa : true,
        ]);
    }
}
