<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function __construct()
    {
        try {
            $request = request();
            $locale = $segment1 = $request->segment(1);
            $fn = $request->segment(2);
            $slug = $request->segment(3);
            $this->locale = $locale ? in_array($locale, ['en', 'ar']) ? $locale : \App::getLocale() : \App::getLocale();
            $langSwitcher = $request->path();
            $uri = \URL::to($langSwitcher);
            if (in_array($langSwitcher, ["", "/"])) {
                $langSwitcher = $this->locale;
            }
            $langSwitcherArr = explode("/", $langSwitcher);
            if (count($langSwitcherArr)) {
                if ($langSwitcherArr[0] == 'en') {
                    $langSwitcherArr[0] = 'ar';
                } elseif ($langSwitcherArr[0] == 'ar') {
                    $langSwitcherArr[0] = 'en';
                } else {
                    $langSwitcherArr[0] = 'en';
                }
            }
            $langSwitcher = implode("/", $langSwitcherArr);
            // dd($langSwitcher);

            $this->langSwitcher = $langSwitcher;
            $this->ql = $this->locale == 'en' ? 'en_' : '';

            $data = collect([]);
            $data->meta_url = route("home", ["locale" => $this->locale]);
            $data->meta_title = "";
            $data->meta_description = "";
            $data->meta_keywords = "";
            $data->seo_image_url = \URL::to("logo/logo.png");
            $this->data = $data;
            \View::share('data', $this->data);
            \View::share('ql', $this->ql);
            \View::share('langSwitcher', $this->langSwitcher);
            \View::share('locale', $this->locale);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
}
