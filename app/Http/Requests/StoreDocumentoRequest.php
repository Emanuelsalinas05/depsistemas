<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Documento::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sistema_id' => ['required', 'exists:sistemas,id'],
            'release_id' => ['nullable', 'exists:releases,id'],
            'tipo' => ['required', 'in:manual_tecnico,manual_usuario,runbook,adr,postmortem'],
            'titulo' => ['required', 'string', 'max:255'],
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
            'sistema_id.required' => 'El sistema es obligatorio.',
            'sistema_id.exists' => 'El sistema seleccionado no existe.',
            'release_id.exists' => 'El release seleccionado no existe.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser: manual_tecnico, manual_usuario, runbook, adr o postmortem.',
            'titulo.required' => 'El título es obligatorio.',
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
            // Verificar que el usuario es miembro del sistema
            if ($this->filled('sistema_id')) {
                $sistema = \App\Models\Sistema::find($this->sistema_id);
                if ($sistema) {
                    $user = $this->user();
                    if (!$user->hasRole('superadmin')) {
                        $isMember = $user->proyectos()
                            ->whereHas('sistema', function ($q) use ($sistema) {
                                $q->where('id', $sistema->id);
                            })
                            ->exists();
                        
                        if (!$isMember) {
                            $validator->errors()->add('sistema_id', 'No eres miembro de este sistema.');
                        }
                    }
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
            'sistema_id' => $this->sistema_id ? (int) $this->sistema_id : null,
            'release_id' => $this->release_id ? (int) $this->release_id : null,
            'estado' => $this->estado ?? 'borrador',
        ]);
    }
}
