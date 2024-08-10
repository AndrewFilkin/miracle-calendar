<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class MatchArrayLengths implements Rule
{
    public function passes($attribute, $value)
    {
        $textArray = request('text', []);
        return count($value) === count($textArray);
    }

    public function message()
    {
        return 'The :attribute array must have the same number of elements as the text array.';
    }
}
