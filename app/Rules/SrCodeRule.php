<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SrCodeRule implements Rule
{
    const SRCODEREGEX = "/^[0-9]{2}-[0-9]{5}$/i";

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
        return preg_match(self::SRCODEREGEX, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valida SR-Code [00-00000].';
    }
}
