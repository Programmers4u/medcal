<?php

namespace App;

use App\Models\User;
use App\TG\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Support\Facades\Log;

class AuthenticateUser
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param UserRepository $users
     * @param Socialite      $socialite
     * @param Guard          $auth
     */
    public function __construct(UserRepository $users, Socialite $socialite, Guard $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
    }

    /**
     * @param bool                     $hasCode
     * @param AuthenticateUserListener $listener
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($provider, $hasCode, AuthenticateUserListener $listener)
    {
        if (!$hasCode) {
            return $this->getAuthorizationFirst($provider);
        }

        $providerUser = $this->getUser($provider);
        
        $unifyData = $this->unifyProvider($providerUser, $provider);

        $user = $this->users->findOrCreate($unifyData);
        if ($user === null) {
            return $this->getAuthorizationFirst($provider);
        }
        
        $this->auth->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst($provider)
    {
        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getUser($provider)
    {
        return $this->socialite->driver($provider)->user();
    }

    private function unifyProvider($providerUser, $provider) : array 
    {
        Log::info('PROVIDER USER:'.serialize($providerUser));

        // dd(serialize($providerUser));
        $token = $providerUser->token;

        switch($provider){
            case 'facebook':
               $first_name = $providerUser->offsetGet('first_name');
               $last_name = $providerUser->offsetGet('last_name');
               $email = $providerUser->getEmail();
               $name = $providerUser->getName();
               $avatar = $providerUser->getAvatar();
               $nickname = $providerUser->getNickname();
            //    $username = $providerUser->getNickname();
            break;
            case 'google':
               $first_name = $providerUser->offsetGet('given_name');
               $last_name = $providerUser->offsetGet('family_name');
               $email = $providerUser->getEmail();
               $name = $providerUser->getName();
               $avatar = $providerUser->getAvatar();
               $nickname = $providerUser->getNickname();
            break;
            case 'linkedin':
               $first_name = $providerUser->offsetGet('given_name');
               $last_name = $providerUser->offsetGet('family_name');
               $email = $providerUser->getEmail();
               $name = $providerUser->getName();
               $avatar = $providerUser->getAvatar();
               $nickname = $providerUser->getNickname();
            break;         
            default:
               $first_name = $providerUser->getName();
               $last_name = $providerUser->getName();
               $email = $providerUser->getEmail();
               $name = $providerUser->getName();
               $avatar = $providerUser->getAvatar();
               $nickname = $providerUser->getNickname();
        };
        
        return [
            User::FIRST_NAME => $first_name,
            User::LAST_NAME => $last_name,
            User::EMAIL => $email,
            User::NAME => $name,
            User::AVATAR => $avatar,
            User::USERNAME => $nickname,
        ];
    }
}
