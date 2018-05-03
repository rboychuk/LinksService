<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Site;
use App\Link;
use Illuminate\Support\Facades\Auth;
use App\Domain;

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
        $url        = $attributes['search_url'];

        $domain = $this->updateDomains($attributes);

        $link = new Link();

        $link->site_id   = $attributes['site_id'];
        $link->domain_id = $domain->id;
        $link->link      = htmlspecialchars($url);
        $link->creator   = Auth::user()->email;
        $link->save();

        return redirect('/links/' . $attributes['site_id']);

    }


    protected function updateDomains($attributes)
    {

        $url        = $attributes['search_url'];
        $parsed_url = $this->parseUrl($url);

        $domain = Domain::where('domain', $parsed_url)->where('site_id', $attributes['site_id'])->first();

        if (is_null($domain)) {
            $domain          = new Domain();
            $domain->domain  = $parsed_url;
            $domain->site_id = $attributes['site_id'];

            $domain->save();
        };
        if (isset($attributes['multiple']) && $attributes['multiple']) {
            Domain::where('domain', $parsed_url)->update(['multiple' => 1]);
        }

        return $domain;

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
        $url        = $attributes['search_url'];

        //if ( ! $this->validator($url)) {
        //
        //    return redirect('/links/' . $attributes['site_id'])->with('incorrect_search',
        //        'Please insert correct url')->with('url', $url);
        //
        //}

        $parsed_url = $this->parseUrl($url);

        $domain = Domain::where('domain', $parsed_url)->where('site_id', $attributes['site_id'])->first();

        $attr = $this->getPageAttribute($attributes);

        $attr['links'] = $attr['links']->filter(function ($item) use ($url) {
            if ($item->link == htmlspecialchars($url)) {
                return true;
            }
        });

        if ( ! $attr['links']->count()) {
            $attr['empty'] = $url;
        }

        if ( ! is_null($domain)) {
            $attr['links'] = Link::where('site_id', $attributes['site_id'])->where('domain_id',
                $domain->id)->orderBy('created_at', 'DESC')->get();
        }

        return view('home', $attr + compact('domain', $parsed_url));


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


    protected function parseUrl($url)
    {

        if (strpos($url, 'http') === false) {
            $url = 'http://' . $url;
        }

        $parse = str_replace('www.', '', parse_url($url, PHP_URL_HOST));

        return $parse;

    }

}
