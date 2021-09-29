<?php

namespace App\Http\Services;

use App\Models\User;

class UserService
{
    protected $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

}
