<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateSistemaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('sistema'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $sistema = $this->route('sistema');
        
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('sistemas', 'slug')->ignore($sistema->id)],
            'descripcion' => ['nullable', 'string'],
            'area_usuaria' => ['nullable', 'string', 'max:255'],
            'dueno_funcional' => ['nullable', 'string', 'max:255'],
            'criticidad' => ['required', 'in:alta,media,baja'],
            'estatus' => ['required', 'in:activo,mantenimiento,legado,deprecado'],
            'url_prod' => ['nullable', 'url', 'max:255'],
            'url_qa' => ['nullable', 'url', 'max:255'],
            'url_dev' => ['nullable', 'url', 'max:255'],
            'repositorio_url' => ['nullable', 'url', 'max:255'],
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
            'nombre.required' => 'El nombre del sistema es obligatorio.',
            'slug.unique' => 'El slug ya está en uso. Elija otro.',
            'criticidad.required' => 'La criticidad es obligatoria.',
            'criticidad.in' => 'La criticidad debe ser: alta, media o baja.',
            'estatus.required' => 'El estatus es obligatorio.',
            'estatus.in' => 'El estatus debe ser: activo, mantenimiento, legado o deprecado.',
            'url_prod.url' => 'La URL de producción debe ser una URL válida.',
            'url_qa.url' => 'La URL de QA debe ser una URL válida.',
            'url_dev.url' => 'La URL de desarrollo debe ser una URL válida.',
            'repositorio_url.url' => 'La URL del repositorio debe ser una URL válida.',
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
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'area_usuaria' => $this->area_usuaria ? trim($this->area_usuaria) : null,
            'dueno_funcional' => $this->dueno_funcional ? trim($this->dueno_funcional) : null,
            'url_prod' => $this->url_prod ? trim($this->url_prod) : null,
            'url_qa' => $this->url_qa ? trim($this->url_qa) : null,
            'url_dev' => $this->url_dev ? trim($this->url_dev) : null,
            'repositorio_url' => $this->repositorio_url ? trim($this->repositorio_url) : null,
        ]);
    }
}
