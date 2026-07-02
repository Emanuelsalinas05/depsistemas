<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProyectoMembersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('manageMembers', $this->route('proyecto'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'members' => ['required', 'array'],
            'members.*.user_id' => ['required', 'exists:users,id'],
            'members.*.rol_en_proyecto' => ['required', 'in:pm,dev,qa,soporte,consulta'],
            'members.*.asignacion_activa' => ['sometimes', 'boolean'],
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
            'members.required' => 'Debe especificar al menos un miembro.',
            'members.array' => 'Los miembros deben ser un array.',
            'members.*.user_id.required' => 'El ID de usuario es obligatorio.',
            'members.*.user_id.exists' => 'El usuario seleccionado no existe.',
            'members.*.rol_en_proyecto.required' => 'El rol en proyecto es obligatorio.',
            'members.*.rol_en_proyecto.in' => 'El rol debe ser: pm, dev, qa, soporte o consulta.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $members = $this->input('members', []);
            $activePMs = collect($members)->where('rol_en_proyecto', 'pm')
                ->where('asignacion_activa', true)
                ->count();

            if ($activePMs === 0) {
                $validator->errors()->add('members', 'El proyecto debe tener al menos un PM activo.');
            }
        });
    }
}
