<?php

namespace App\Http\Requests;

use App\Rules\Base64Image;

class UpdateUserDetailsRequest extends CustomFormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+63(9\d{9})$/'
            ],
            'birthday' => 'required|date',
            'avatar' => ['nullable', 'string', new Base64Image]
        ];
    }
}
