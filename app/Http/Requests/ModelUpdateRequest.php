<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelUpdateRequest extends FormRequest
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
            'average_price' => ['required', 'numeric', 'min:10000', 'max:9999999'],
        ];
    }
}
