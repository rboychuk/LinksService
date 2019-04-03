<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Site;
use Illuminate\Http\Request;

class DisavowController extends Controller
{

    public function index()
    {

        $sites = Site::all();

        return view('disavow.index', compact('sites'));
    }


    public function update(Request $request)
    {
        $site_id = $request->get('site_id');

        $ahrefs_links = $this->getContentFromRequest('ahrefs_list');
        $google_links = $this->getContentFromRequest('google_list');

        $array = array_merge($ahrefs_links, $google_links);
        $array = array_unique($array);

        $domains = Domain::where('site_id', $site_id)->pluck('domain')->toArray();

        $diff = array_diff($array, $domains);
        asort($diff);

        $url = $this->saveResults($diff, $site_id);

        return view('disavow.update', compact('url'));

    }


    protected function getContentFromRequest($fileName)
    {


        $upload = storage_path('tmp_file_' . $fileName . 'csv');

        $results = move_uploaded_file($_FILES[$fileName]['tmp_name'], $upload);

        $content = [];

        if ( ! $results) {
            return [];
        }
        $f = fopen($upload, 'r');

        while ( ! feof($f)) {
            if ($c = fgetcsv($f)) {
                $content[] = $c[0];
            }
        }
        unset($content[0]);

        return $content;

    }


    protected function saveResults($results, $site_id)
    {
        try {
            $site_name = str_replace('.', '_', Site::find($site_id)->name);

            $date = date('Y_m_d');

            $filename = $site_name . '_disavow_' . $date . '.csv';

            $path = public_path($filename);

            $f = fopen($path, 'w');
            foreach ($results as $result) {
                fputcsv($f, [$result]);
            }

            $url = url($filename);
        } catch (\Exception $e) {
            $url = false;
        }

        return $url;
    }
}
