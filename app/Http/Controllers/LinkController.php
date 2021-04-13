<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Site;
use App\Link;
use Illuminate\Support\Facades\Auth;
use App\Domain;
use Illuminate\Support\Facades\Log;

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
        $domain     = $this->updateDomains($attributes);

        $this->createLink($attributes['site_id'], $domain->id, $url, Auth::user()->email, $attributes['meta']);

        return redirect('/links/' . $attributes['site_id']);

    }


    public function updateLinks(Request $request)
    {

        $attributes = $request->all();

        $link = Link::find($attributes['id']);

        Link::unguard();

        foreach ($attributes as $key => $value) {
            if ( ! is_null($link->getAttribute($key))) {
                $link->$key = $value;
            }
        }

        $link->enabled = isset($attributes['validate']) == 'on' ? 1 : 0;

        //if (isset($attributes['dublicate_domain'])) {
        //    $link->dublicate_domain = $attributes['dublicate_domain'] == 'on' ? true : false;
        //}

        $link->save();

        $request->request->add(['site_id' => $link->site_id, 'user_email' => $link->creator]);

        //return redirect()->action('ReportController@makeReport');
        return app(ReportController::class)->makeReport($request);

    }


    protected function createLink(
        $site_id,
        $domain_id,
        $url,
        $user_email,
        $meta = '',
        $created_at = false,
        $target_link = '',
        $anchor = '',
        $dublicate = false
    ) {

        if ($url) {
            $link = new Link();

            $link->site_id          = $site_id;
            $link->domain_id        = $domain_id;
            $link->target_url       = $target_link;
            $link->anchor           = $anchor;
            $link->dublicate_domain = $dublicate;
            $link->link             = htmlspecialchars($url);
            $link->creator          = $user_email;
            $link->meta             = $meta;

            if ($created_at) {
                $link->created_at = $created_at;
            }

            $link->save();
        }


    }


    public function updateDomains($attributes)
    {

        $url        = $attributes['search_url'];
        $parsed_url = $this->parseUrl($url);

        $domain = Domain::where('domain', $parsed_url)->where('site_id', $attributes['site_id'])->first();

        if (is_null($domain)) {
            $domain          = new Domain();
            $domain->domain  = $parsed_url;
            $domain->user_id = isset($attributes['user_id']) ? $attributes['user_id'] : Auth::user()->id;
            $domain->site_id = $attributes['site_id'];

            $domain->save();

            $domain->dublicate = false;
        } else {
            $domain->dublicate = true;
        };

        if (isset($attributes['multiple']) && $attributes['multiple']) {
            Domain::where('domain', $parsed_url)->update(['multiple' => 1, 'user_id' => Auth::user()->id]);
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


    public function uploadFiles(Request $request)
    {

        $meta       = $request->get('meta');
        $site_id    = $request->get('site_id');
        $uploadfile = storage_path(basename($_FILES['file_report']['name']));

        //$type = $_FILES['file_report']['type'];
        //
        //if ($type != 'text/csv') {
        //    return redirect('/links/' . $site_id)->with('upload_error', 'Please use just CSV files (not '.$type.')');
        //}

        try {
            list($email, $month, $year) = explode('__',
                str_replace('.csv', '', strtolower($_FILES['file_report']['name'])));

            $user = User::where('email', $email)->first();

            if (is_null($user)) {
                return redirect('/links/' . $site_id)->with('upload_error', 'Incorrect user name');
            }
            $date = date('Y-m-d H:i:s', strtotime($year . '-' . $month));

            move_uploaded_file($_FILES['file_report']['tmp_name'], $uploadfile);
            $content = [];

            $f = fopen($uploadfile, 'r');

            while ( ! feof($f)) {
                if ($c = fgetcsv($f)) {
                    if(count($c)==1){
                        $c = fgetcsv($f,0,';');
                    }
                    $content[] = $c;
                }
            }

            $counter = 0;

            try {
                foreach ($content as $record) {
                    $url         = $record[0];
                    $target_link = count($record) > 1 ? $record[1] : '';
                    $anchor      = count($record) > 2 ? $record[2] : '';

                    if ($l = Link::where('link', htmlspecialchars($url))->first()) {
                        continue;
                    }

                    $domain = $this->updateDomains(['site_id' => $site_id, 'search_url' => $url]);
                    $this->createLink($site_id, $domain->id, $url, $user->email, $meta, $date, $target_link, $anchor,
                        $domain->dublicate);
                    $counter++;
                }
            } catch (\Exception $e) {
                Log::error($e);
            }

            return redirect('/links/' . $site_id)->with('counter', $counter);

        } catch (\Exception $e) {
            return redirect('/links/' . $site_id)->with('upload_error', 'Something went wrong!!');
        }


    }

}
