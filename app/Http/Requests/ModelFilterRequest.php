<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'greater' => ['sometimes', 'required_with:lower', 'numeric', 'min:100000', 'max:9999999',  'lte:lower'],
            'lower' => ['sometimes', 'required_with:greater', 'numeric', 'min:100000', 'max:9999999',  'gte:greater'],
        ];
    }
}
