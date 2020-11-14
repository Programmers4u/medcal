<?php

namespace App;

use App\TG\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;

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

        // logger()->info('PROVIDER USER:'.serialize($providerUser));
        // dd(serialize($providerUser));

        // switch($provider){
        //     case 'facebook':
        //        $first_name = $providerUser->offsetGet('first_name');
        //        $last_name = $providerUser->offsetGet('last_name');
        //        break;
         
        //     case 'google':
        //        $first_name = $providerUser->offsetGet('given_name');
        //        $last_name = $providerUser->offsetGet('family_name');
        //        break;
         
        //     case 'linkedin':
        //        $first_name = $providerUser->offsetGet('given_name');
        //        $last_name = $providerUser->offsetGet('family_name');
        //        break;

        //        // You can also add more provider option e.g. linkedin, twitter etc.
         
        //     default:
        //        $first_name = $providerUser->getName();
        //        $last_name = $providerUser->getName();
        //  }
        
        $user = $this->users->findOrCreate($providerUser);
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
}
