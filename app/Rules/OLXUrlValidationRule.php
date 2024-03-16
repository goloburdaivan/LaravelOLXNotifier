<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OLXUrlValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!URL::isValidUrl($value))
            $fail(config('olx.invalidUrlMessage'));
        $urlParts = config('olx.product_parts');
        if (!Str::containsAll($value, $urlParts))
            $fail(config('olx.invalidUrlMessage'));
    }
}
