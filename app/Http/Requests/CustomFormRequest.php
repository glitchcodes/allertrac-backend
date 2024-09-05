<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CustomFormRequest extends FormRequest
{
    use ApiResponseTrait;

    /**
     * Send a custom JSON response when validation fails.
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        $response = $this->sendInvalidInputResponse($validator);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
