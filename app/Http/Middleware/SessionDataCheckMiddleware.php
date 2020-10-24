<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
 
class SessionDataCheckMiddleware {
 
    /**
     * Check session data, if role is not valid logout the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // Expire the session after the given number of seconds of inactivity
        $bag = $request->cookie('la');
        if(empty($bag)) setcookie('la',time(),null,'/');
        // logger()->info($bag);
        $max = config('session.lifetime') * 60; // min to hours conversion
        if ($bag && $max < (time() - (int)$bag)) {
                // Delete session data created by this app:
            //$request->cookies->remove('la'); // remove all the session data
            Auth::logout(); // logout user                        
        }
        setcookie('la',time(),null,'/');
        return $next($request);
    }
 
}