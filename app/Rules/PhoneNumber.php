<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(0[1-9][0-9]{8}|(\+84)[1-9][0-9]{8})$/', $value)) {
            $fail("The $attribute must be a valid Vietnamese phone number.");
        }
    }
}
