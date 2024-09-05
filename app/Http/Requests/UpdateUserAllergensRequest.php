<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserAllergensRequest extends FormRequest
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
            'allergens' => 'required|array',
            'allergens.*' => 'integer'
//            'allergens.*' => [
//                'required',
//                'integer',
//                Rule::unique('user_allergens', 'allergen_id')->where('user_id', Auth::user()->id)
//            ]
        ];
    }
}
