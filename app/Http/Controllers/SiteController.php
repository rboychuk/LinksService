<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Site;

class SiteController extends Controller
{

    protected $pattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';


    public function addSite(Request $request)
    {
        $attributes = $request->all();

        if ($this->validator($attributes['site_name'])) {
            $site = new Site();

            $site->name = $attributes['site_name'];

            $site->save();

            return redirect('/links/' . $site->id);
        }

        return redirect('/home')->with('incorrect_site', 'Please insert correct site name')->with('site_url',
            $attributes['site_name']);


    }


    public function deleteSite(Request $request)
    {
        $attributes = $request->all();

        Site::where('id', $attributes['site_id'])->delete();

        return redirect('/home');
    }


    protected function validator($url)
    {

        return (bool) preg_match($this->pattern, $url);

    }
}
