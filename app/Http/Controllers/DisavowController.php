<?php

namespace App\Http\Controllers;

use App\Disavow;
use App\GrayDomain;
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

        $disavow_links = $this->checkDisavowLinks($this->getContentFromRequest('disavow_list'));
        asort($disavow_links);

        $array = array_merge($ahrefs_links, $google_links);
        $array = array_unique($array);
        asort($array);

        $count_unique = count($array);

        $domains      = Domain::pluck('domain')->toArray();
        $domains      = array_unique($domains);
        $gray_domains = GrayDomain::pluck('domain')->toArray();
        asort($gray_domains);
        asort($domains);

        //$this->saveResults($disavow_ddd, null, 'disavow_from_db');
        $links_in_disavow = array_intersect($array, $disavow_links);
        $links_in_disavow_url = $this->saveResults($links_in_disavow, null,'links_in_disavow_file');
        $links_in_gray     = array_intersect($array, $gray_domains);
        $links_in_gray_url     = $this->saveResults($links_in_gray, null,'links_in_gray_list');

        $links_in_domain = array_intersect($array,$domains);

        $array                  = array_diff($array, $disavow_links);
        $count_in_disavow_links = $count_unique - count($array);
        $array                  = array_diff($array, $domains);
        $array                  = array_diff($array, $gray_domains);

        $diff = array_unique($array);

        asort($diff);

        $url = $this->saveResults($diff, $site_id);

        return view('disavow.update',
            compact('url', 'ahrefs_links', 'google_links', 'disavow_links', 'domains', 'gray_domains', 'diff',
                'count_unique', 'count_in_disavow_links',
            'links_in_disavow_url','links_in_gray_url','links_in_disavow','links_in_gray','links_in_domain'));

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

        $key = 0;

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


    protected function saveResults($results, $site_id = null, $site_name = null)
    {
        try {
            $site_name = $site_id ? str_replace('.', '_', Site::find($site_id)->name) : $site_name;

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
            $url = str_replace('www.', '', $url);
            preg_match($pattern, $url, $matches);
            if (count($matches) > 2) {
                $new_list[] = $matches[2];
            }
        }

        return $new_list;

    }


    public function extractDomains(Request $request)
    {

        $results = [];

        $file = $request->file('extract_domain')->openFile('r');

        while ( ! $file->eof()) {
            $results[] = $file->fgetcsv()[0];
        }

        $results = $this->checkDisavowLinks($results);

        asort($results);

        $url = $this->saveResults($results, null, "extract");

        return redirect(secure_url('disavow'))->with('extractDomains', $url);

    }


    public function updateGrayDomains(Request $request)
    {

        $results = [];

        $file = $request->file('gray_domain')->openFile('r');

        while ( ! $file->eof()) {
            $results[] = $file->fgetcsv()[0];
        }

        $results = array_unique($results);
        $results = $this->checkDisavowLinks($results);
        GrayDomain::unguard();

        $counter = 0;

        foreach ($results as $domain) {
            if ($domain) {
                $res     = GrayDomain::updateOrCreate(
                    ['domain' => $domain]
                );
                $counter += $res->wasRecentlyCreated;
            }
        }

        return redirect(secure_url('disavow'))->with('uploaded_domains', $counter);

    }

}
