<?php

namespace App\Http\Requests\Dashboard\ProductCategories;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|string|max:500',
            'parent_id' => 'required|numeric',
            'tax_rate' => 'required|int|min:0|max:100',
            'status' => 'required|in:ACTIVE,PASSIVE',
            'ranking' => 'numeric'
        ];
    }
}
