<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'captcha' => 'required|captcha_api' . request('key') . ',math',
            'email' => 'required',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return ['captcha.captcha' => 'Invalid'];
    }
}