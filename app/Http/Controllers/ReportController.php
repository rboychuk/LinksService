<?php

namespace App\Http\Controllers;

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

        return view('report', compact('users', 'sites'));

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
            fputcsv($file, [$item['name'],$item['link'], $item['creator'],]);
        }

        fclose($file);

        return url($path);
    }
}
