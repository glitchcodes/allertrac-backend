<?php

namespace App\Http\Requests;

class EmergencyContactRequest extends CustomFormRequest
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
            'full_name' => 'required|string',
            'phone_number' => [
                'required',
                'string',
                'regex:/^(09|\+639)\d{9}$/',
                'min:10'
            ], //'required|string|regex:/^(09|\+639)\d{9}$/|min:10',
            'relationship' => 'required|string|in:parent,spouse,sibling,child,other',
            'email' => 'nullable|email'
        ];
    }
}
