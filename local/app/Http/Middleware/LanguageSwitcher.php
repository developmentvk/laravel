<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Config;
use Session;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('locale')) {
            Session::put('locale', Config::get('app.locale'));
        }
        $locale = $request->locale ? $request->locale : session('locale');
        App::setLocale($locale);
        return $next($request);
    }
}
