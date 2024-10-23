<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class Base64Image implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the value is a valid data URL for images
        if (preg_match('/^data:image\/(png|jpg|jpeg|gif|webp|bmp);base64,/', $value)) {
            // Get the base64 part of the data URL
            $base64 = preg_replace('/^data:image\/(png|jpg|jpeg|gif|webp|bmp);base64,/', '', $value);

            // Check if the base64 string is valid
            if (base64_encode(base64_decode($base64, true)) === $base64) {
                // Decode the base64 string
                $image = base64_decode($base64);
                // Check if the image is valid
                if (!imagecreatefromstring($image)) {
                    $fail('The :attribute must be a valid data URL string for an image.');
                }
            } else {
                $fail('The :attribute must be a valid data URL string for an image.');
            }
        } else {
            $fail('The :attribute must be a valid data URL string for an image.');
        }
    }
}
