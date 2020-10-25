<?php

namespace App\Http\Controllers;
use App;
class WelcomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }

    public function index()
    {
        $locale = preg_replace('/_[A-Z]*/is','', App::getLocale());
        return view(env('APP_FIP_THEME','welcome'), compact('locale'));
    }
    
    public function contactForm(){
        return response()->json(['msg'=>'ok']);
    }
}
