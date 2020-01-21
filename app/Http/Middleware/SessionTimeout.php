<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;

class SessionTimeout {

    protected $session;
    protected $timeout = 3600;

    public function __construct(Store $session){
        $this->session = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isLoggedIn = $request->path() != 'logout';
        if(!session('lastActivityTime')) {
            $this->session->put('lastActivityTime', time());
        } else if(time() - $this->session->get('lastActivityTime') > $this->timeout) {
            $this->session->forget('lastActivityTime');
            //$cookie = cookie('intend', $isLoggedIn ? url()->current() : 'dashboard');
            //$email = $request->user()->email;
            auth()->logout();
            return redirect('logout',403);
            //return flash('You had not activity in '.$this->timeout/60 .' minutes ago.', 'warning');
        }
        $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');
        return $next($request);
    }

}