<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Site;
use App\Link;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{

    protected $pattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';


    protected function getPageAttribute($attributes)
    {
        $id = $attributes['site_id'];

        $links        = Link::where('site_id', $id)->orderBy('created_at', 'DESC')->get();
        $sites        = Site::get();
        $current_site = Site::where('id', $id)->first();
        setcookie('site_number', $id);

        return compact('sites', 'links', 'current_site');
    }


    public function addLinks(Request $request)
    {

        $attributes = $request->all();

        $link = new Link();

        $link->site_id = $attributes['site_id'];
        $link->link    = htmlspecialchars($attributes['search_url']);
        $link->creator = Auth::user()->email;
        $link->save();

        return redirect('/links/' . $attributes['site_id']);

    }


    public function deleteLink(Request $request)
    {
        $attributes = $request->all();

        Link::where('id', $attributes['id'])->delete();

        return redirect('/links/' . $attributes['site_id']);
    }


    public function searchLinks(Request $request)
    {

        $attributes = $request->all();

        if ($this->validator($attributes['search_url'])) {
            $attr = $this->getPageAttribute($attributes);

            $attr['links'] = $attr['links']->filter(function ($item) use ($attributes) {
                if ($item->link == $attributes['search_url']) {
                    return true;
                }
            });

            if ( ! $attr['links']->count()) {
                $attr['empty'] = $attributes['search_url'];
            }

            return view('home', $attr);
        }

        return redirect('/links/' . $attributes['site_id'])->with('incorrect_search',
            'Please insert correct url')->with('url', $attributes['search_url']);

    }


    public function getLinks($site_id)
    {

        $site_id = (int) $site_id;
        $attr    = $this->getPageAttribute(compact('site_id'));

        return view('home', $attr);

    }


    protected function validator($url)
    {

        $match = preg_match($this->pattern, $url, $matches);

        return $match;

    }

}
