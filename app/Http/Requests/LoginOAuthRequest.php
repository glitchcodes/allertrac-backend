<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class LoginOAuthRequest extends CustomFormRequest
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
            'email' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'provider' => [
                'required',
                'string',
                Rule::in(['google', 'facebook', 'twitter'])
            ],
            'account_id' => 'required|string',
            'id_token' => 'required|string'
        ];
    }
}
