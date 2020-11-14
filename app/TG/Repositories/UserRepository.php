<?php

namespace App\TG\Repositories;

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
        return User::create($userData);

        // return User::create([
        //     'username' => $userData->nickname,
        //     'name'     => $userData->nickname,
        //     'email'    => $userData->email,
        // ]);
    }
}
