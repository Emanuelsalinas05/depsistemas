<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoveTareaStateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $tarea = $this->route('tarea');
        $nuevoEstado = $this->input('estado');
        
        return $this->user()->can('moveState', [$tarea, $nuevoEstado]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'estado' => ['required', 'in:nuevo,en_curso,en_revision,listo_release,cerrado'],
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
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: nuevo, en_curso, en_revision, listo_release o cerrado.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $tarea = $this->route('tarea');
            $nuevoEstado = $this->input('estado');
            $user = $this->user();

            // QA solo puede mover hacia en_revision o listo_release
            if ($user->hasRole('qa') && !in_array($nuevoEstado, ['en_revision', 'listo_release'])) {
                $validator->errors()->add('estado', 'Como QA solo puedes mover tareas a "en revisión" o "listo para release".');
            }

            // Soporte solo puede mover hasta en_revision
            if ($user->hasRole('soporte') && !in_array($nuevoEstado, ['nuevo', 'en_curso', 'en_revision'])) {
                $validator->errors()->add('estado', 'Como soporte solo puedes mover tareas hasta "en revisión".');
            }

            // Dev no puede cerrar
            if ($user->hasRole('dev') && $nuevoEstado === 'cerrado') {
                $validator->errors()->add('estado', 'No puedes cerrar tareas. Solo el PM puede hacerlo.');
            }
        });
    }
}
