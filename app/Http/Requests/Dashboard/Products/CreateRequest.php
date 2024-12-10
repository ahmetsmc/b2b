<?php

namespace App\Http\Requests\Dashboard\Products;

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
            'category_id' => 'required|numeric|exists:product_categories,id',
            'price' => 'required|money',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'stock' => 'required|numeric|min:0',
            'code' => 'required|string|unique:products,code',
            'content' => 'string',
            'status' => 'required|in:ACTIVE,PASSIVE'
        ];
    }
}
