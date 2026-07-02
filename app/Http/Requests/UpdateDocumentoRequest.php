<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('documento'));
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
            'release_id' => ['nullable', 'exists:releases,id'],
            'tipo' => ['required', 'in:manual_tecnico,manual_usuario,runbook,adr,postmortem'],
            'estado' => ['required', 'in:borrador,publicado,archivado'],
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
            'release_id.exists' => 'El release seleccionado no existe.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser: manual_tecnico, manual_usuario, runbook, adr o postmortem.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: borrador, publicado o archivado.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $documento = $this->route('documento');
            
            // No se puede actualizar un documento publicado directamente
            if ($documento->estado === 'publicado' && $this->estado !== 'publicado') {
                $validator->errors()->add('estado', 'No se puede cambiar el estado de un documento publicado. Use la función de publicación.');
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
            'release_id' => $this->release_id ? (int) $this->release_id : null,
        ]);
    }
}
