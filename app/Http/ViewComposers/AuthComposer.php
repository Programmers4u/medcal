<?php

namespace App\Http\ViewComposers;

use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Support\Facades\Cache;

class AuthComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose()
    {
        view()->share('isGuest', auth()->guest());
        view()->share('signedIn', auth()->check());
        view()->share('user', auth()->user());
        view()->share('timezone', session()->get('timezone'));

        $dir_avatar = base_path().DIRECTORY_SEPARATOR.env('STORAGE_PATH').DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'avatar';
        $avatar = 'avatar_'.auth()->user()->id;
        $avatar = findFile($avatar,$dir_avatar);

        if (auth()->user()) {
            view()->share('gravatarURL', Gravatar::get(auth()->user()->email, ['size' => 24, 'secure' => true]));
            view()->share('appointments', $this->getActiveAppointments());
        } else {
            view()->share('gravatarURL', 'http://placehold.it/150x150');
            view()->share('appointments', collect([]));
        }

        if($avatar) {
            $toPublic = env('STORAGE_PATH').DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'avatar';
            checkDir('public'.DIRECTORY_SEPARATOR.$toPublic);
            $command = 'cp '.$dir_avatar.DIRECTORY_SEPARATOR.$avatar.' '.base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$toPublic.DIRECTORY_SEPARATOR.$avatar;
            system($command);
            view()->share('gravatarURL', DIRECTORY_SEPARATOR.$toPublic.DIRECTORY_SEPARATOR.$avatar);
        }

    }

    protected function getActiveAppointments()
    {
        return Cache::get('user-{auth()->id()}-active-appointments', function () {
            return auth()->user()->appointments()->active()->get();
        });
    }
}
