<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDocumentoVersionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('addVersion', $this->route('documento'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'version' => ['required', 'string', 'max:50'],
            'contenido' => ['nullable', 'string'],
            'archivo_path' => ['nullable', 'string', 'max:255'],
            'mermaid_source' => ['nullable', 'string'],
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
            'version.required' => 'La versión es obligatoria.',
            'version.max' => 'La versión no puede exceder 50 caracteres.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'version' => trim($this->version ?? ''),
            'archivo_path' => $this->archivo_path ? trim($this->archivo_path) : null,
        ]);
    }
}
