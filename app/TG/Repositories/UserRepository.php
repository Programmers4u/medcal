<?php

namespace App\TG\Repositories;

use App\Events\NewUserWasRegistered;
use App\Models\User;

class UserRepository
{
    /**
     * @param $userData
     *
     * @return static
     */
    public function findOrCreate($userData)
    {
        $user = User::where('email', '=', $userData[User::EMAIL])->orWhere('username', '=', $userData[User::USERNAME])->first();
        if ($user !== null) {
            return $user;
        }
        $user = User::create($userData);
        event(new NewUserWasRegistered($user));
        return $user;
    }
}
