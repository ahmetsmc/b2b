<?php

namespace App\Http\Requests\Dashboard\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $productId = $this->route('id');

        return [
            'title' => 'required|string|max:500',
            'category_id' => 'required|numeric|exists:product_categories,id',
            'price' => 'required|money',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'stock' => 'required|numeric|min:0',
            'code' => 'required|string|unique:products,code,' . $productId . ',id',
            'content' => 'nullable|string',
            'status' => 'required|in:ACTIVE,PASSIVE',
            'unit_id' => 'required|exists:product_units,id',
            'lead_time' => 'nullable|max:500',
            'variants' => 'nullable|array',
            'variants.*.title' => 'required|max:500',
            'variants.*.code' => 'required|string',
            'variants.*.price' => 'required|money',
            'variants.*.stock' => 'required|numeric|min:0',
            'variants.*.image' => 'nullable|image|max:5000'
        ];
    }

    /**
     * Get custom attribute names for validator.
     *
     * @return array
     */
    public function attributes(): array
    {
        $attributes = [];

        if ($this->has('variants')) {
            foreach ($this->input('variants') as $index => $variant) {
                $attributes["variants.{$index}.stock"] = str(trans('Product variants stock'))->lower();
                $attributes["variants.{$index}.title"] = str(trans('Product variants title'))->lower();
                $attributes["variants.{$index}.code"] = str(trans('Product variants code'))->lower();
            }
        }

        return $attributes;
    }
}
