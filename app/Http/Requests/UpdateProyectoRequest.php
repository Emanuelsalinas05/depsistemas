<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateProyectoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('proyecto'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $proyecto = $this->route('proyecto');
        
        return [
            'sistema_id' => ['nullable', 'exists:sistemas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('proyectos', 'slug')->ignore($proyecto->id)],
            'objetivo' => ['nullable', 'string'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'estatus' => ['required', 'in:planeado,en_progreso,en_pausa,cerrado'],
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
            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'slug.unique' => 'El slug ya está en uso. Elija otro.',
            'sistema_id.exists' => 'El sistema seleccionado no existe.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estatus.required' => 'El estatus es obligatorio.',
            'estatus.in' => 'El estatus debe ser: planeado, en_progreso, en_pausa o cerrado.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim($this->nombre ?? ''),
            'slug' => $this->slug ? Str::slug(trim($this->slug)) : Str::slug(trim($this->nombre ?? '')),
            'objetivo' => $this->objetivo ? trim($this->objetivo) : null,
            'sistema_id' => $this->sistema_id ? (int) $this->sistema_id : null,
            'fecha_inicio' => $this->fecha_inicio ?: null,
            'fecha_fin' => $this->fecha_fin ?: null,
        ]);
    }
}
