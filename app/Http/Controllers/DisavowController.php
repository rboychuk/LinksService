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

        $ahrefs_links  = $this->getContentFromRequest('ahrefs_list');
        $google_links  = $this->getContentFromRequest('google_list');
        $disavow_links = $this->checkDisavowLinks($this->getContentFromRequest('disavow_list'));

        $array = array_merge($ahrefs_links, $google_links);

        $domains = Domain::where('site_id', $site_id)->pluck('domain')->toArray();

        $diff = array_diff($array, $domains);
        $diff = array_unique(array_diff($diff, $disavow_links));
        asort($diff);
        asort($disavow_links);

        $url = $this->saveResults($diff, $site_id);

        return view('disavow.update', compact('url'));

    }


    protected function getContentFromRequest($fileName)
    {

        $upload = storage_path('tmp_file_' . $fileName . '.csv');

        if (file_exists($upload)) {
            unlink($upload);
        }

        $results = move_uploaded_file($_FILES[$fileName]['tmp_name'], $upload);

        $content = [];

        if ( ! $results) {
            return [];
        }
        $f = fopen($upload, 'r');

        $key = $fileName == 'ahrefs_list' ? 1 : 0;

        while ( ! feof($f)) {
            if ($c = fgetcsv($f)) {
                if (isset($c[$key])) {
                    $string    = $c[$key];
                    $string    = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $string);
                    $content[] = trim(str_replace('"', '', $string), " ");
                }
            }
        }

        fclose($f);
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
            fclose($f);

            $url = url($filename);
        } catch (\Exception $e) {
            $url = false;
        }

        return $url;
    }


    public function checkDisavowLinks($list)
    {

        $pattern = '/^(https?:\/\/)?([\da-z\.-]+\.[a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $new_list = [];

        foreach ($list as $url) {
            $url = str_replace('domain:', '', $url);
            preg_match($pattern, $url, $matches);
            if (count($matches) > 2) {
                $new_list[] = $matches[2];
            }
        }

        return $new_list;

    }
}
