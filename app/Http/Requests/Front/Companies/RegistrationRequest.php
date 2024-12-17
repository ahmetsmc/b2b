<?php

namespace App\Http\Requests\Front\Companies;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|min:5|max:500',
            'email' => 'required|email|unique:users,email',
            'company_name' => 'required|min:5|max:500',
            'company_address' => 'required|min:5|max:500',
            'password' => 'required|max:500',
            'locale' => 'required|min:2|exists:languages,locale'
        ];
    }
}
