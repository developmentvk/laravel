<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $ql;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->ql = \App::getLocale() == 'en' ? 'en_' : '';
            return $next($request);
        });
        
        \View::share('urlPrefix', env('urlPrefix'));
    }
}
