<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\Site;

class ReportController extends Controller
{

    public function index()
    {

        $users = User::get();
        $sites = Site::get();

        $unique        = Link::join('sites', 'sites.id', '=', 'site_id')->orderBy('sites.name')->get();
        $unique_domain = Domain::join('sites', 'sites.id', '=', 'site_id')->orderBy('sites.name')->get();

        $results = [];

        foreach ($unique as $link) {
            if ( ! isset($results[$link->name])) {
                $results[$link->name] = [];
            }
            $results[$link->name][] = $this->parseUrl($link->link);
        }

        foreach ($unique_domain as $link) {
            if ( ! isset($results[$link->name])) {
                $results[$link->name] = [];
            }
            $results[$link->name][] = $this->parseUrl($link->domain);
        }

        foreach($results as $key=>$result){
            $results[$key]=array_unique($result);
            $results[$key]=$this->makeDownloadLinks($key, $results[$key]);
        }

        return view('report', compact('users', 'sites', 'results'));

    }


    public function makeDownloadLinks($name, $links)
    {

        $path = 'domains_' . $name . '.csv';

        $file = fopen(public_path($path), 'w');

        foreach ($links as $item) {
            fputcsv($file, [$item]);
        }

        fclose($file);

        return url($path);

    }


    public function makeReport(Request $request)
    {

        $attr = $request->all();

        $links = Link::join('sites', 'sites.id', '=', 'site_id')
                     ->where('creator', $attr['user_email'])
                     ->where('sites.id', $attr['site_id'])
                     ->get();
        $users = User::get();
        $sites = Site::get();

        $path = $this->makeCsv($attr['user_email'], $links->toArray());

        return view('report', compact('links', 'users', 'sites', 'path'));

    }


    public function makeCsv($email, $array)
    {

        $path = 'report_' . md5($email) . '.csv';

        $file = fopen(public_path($path), 'w');

        foreach ($array as $item) {
            fputcsv($file, [$item['name'], $item['link'], $item['creator'],]);
        }

        fclose($file);

        return url($path);
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