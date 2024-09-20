<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug(Str::limit($this->name, 100, ''), '-'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255', 'unique:brand_models,name'],
            'slug' => ['required', 'string'],
            'average_price' => ['sometimes', 'nullable', 'numeric', 'min:100000', 'max:9999999'],
        ];
    }
}
