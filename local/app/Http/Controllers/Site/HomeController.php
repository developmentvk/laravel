<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\SiteController;
use Illuminate\Http\Request;

class HomeController extends SiteController
{
    public function getSoon()
    {
        return view('site.home.coming-soon');
    }
}
