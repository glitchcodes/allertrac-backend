<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookmarkMealRequest extends FormRequest
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
            // Must be a Edamam URI and unique in the bookmarks table
            'uri' => [
                'required',
                'string',
                'regex:/^http:\/\/www\.edamam\.com\/ontologies\/edamam\.owl#/',
                'unique:App\Models\BookmarkedMeal,uri'
            ]
        ];
    }
}
