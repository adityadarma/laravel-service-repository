<?php

namespace AdityaDarma\LaravelServiceRepository\Rules;

use Illuminate\Contracts\Validation\Rule;

class PreventXSS implements Rule
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
    public function passes($attribute, $value): bool
    {
        $fileUpload = file_get_contents($value);

        return !str_contains($fileUpload, '/JavaScript');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute have script javascript.';
    }
}
