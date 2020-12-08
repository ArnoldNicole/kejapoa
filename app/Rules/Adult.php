<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DateTime;

class Adult implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        date_diff(date_create($value), date_create('today'))->y>18;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must be 18 years old and above.';
    }
}
