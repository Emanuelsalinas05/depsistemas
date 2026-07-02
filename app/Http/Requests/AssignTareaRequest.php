<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('assign', $this->route('tarea'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'asignado_a' => ['required', 'exists:users,id'],
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
            'asignado_a.required' => 'Debe seleccionar un usuario.',
            'asignado_a.exists' => 'El usuario seleccionado no existe.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $tarea = $this->route('tarea');
            $asignadoA = $this->input('asignado_a');

            // Verificar que el usuario asignado es miembro del proyecto
            if ($asignadoA && !$tarea->proyecto->miembros()->where('users.id', $asignadoA)->exists()) {
                $validator->errors()->add('asignado_a', 'El usuario debe ser miembro del proyecto.');
            }
        });
    }
}
