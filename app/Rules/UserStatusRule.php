<?php

namespace App\Rules;

use App\Enums\UserStatusEnum;
use Illuminate\Contracts\Validation\Rule;

class UserStatusRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value, array_values((new \ReflectionClass(UserStatusEnum::class))->getConstants()));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}
