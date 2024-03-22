<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class MaxUsers implements Rule
{
    protected $maxUsers;

    public function __construct($maxUsers)
    {
        $this->maxUsers = $maxUsers;
    }

    public function passes($attribute, $value)
    {
        return User::count() < $this->maxUsers;
    }

    public function message()
    {
        return "The maximum number of users has been reached.";
    }
}
